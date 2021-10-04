<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Notifications\BookNotification;
use App\Notifications\FavoriteBookNotification;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Favorite\FavoriteRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;

class BookController extends Controller
{
    protected $bookRepo;
    protected $categoryRepo;
    protected $imageRepo;
    protected $reviewRepo;
    protected $likeRepo;
    protected $favoriteRepo;
    protected $userRepo;

    public function __construct(
        BookRepositoryInterface $bookRepo,
        CategoryRepositoryInterface $categoryRepo,
        ImageRepositoryInterface $imageRepo,
        ReviewRepositoryInterface $reviewRepo,
        LikeRepositoryInterface $likeRepo,
        FavoriteRepositoryInterface $favoriteRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->bookRepo = $bookRepo;
        $this->categoryRepo = $categoryRepo;
        $this->imageRepo = $imageRepo;
        $this->reviewRepo = $reviewRepo;
        $this->likeRepo = $likeRepo;
        $this->favoriteRepo = $favoriteRepo;
        $this->userRepo = $userRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = $this->bookRepo->getAllBooksWithCategoriesAndImages();

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepo->getAllSubcategoriesWithBooks();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->all();
        $book = $this->bookRepo->create($data);

        $file = $data['image'];
        $image = [];
        $image['imageable_type'] = get_class($book);
        $image['imageable_id'] = $book->id;
        $image['path'] = $book->id . '_' . $file->getClientOriginalName();

        $this->imageRepo->create($image);
        $file->move(public_path('uploads/books'), $image['path']);

        return redirect()->route('books.index')->with('success', __('messages.add-book-success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = $this->bookRepo->getBookWithRelationsById($id, ['category', 'image']);
        $reviews = $this->reviewRepo->getReviewsWithUsersAndCommentsAndLikesByBookId($id);

        return view('admin.books.show', compact('book', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = $this->bookRepo->getBookWithRelationsById($id, ['category', 'image']);
        $categories = $this->categoryRepo->getAllSubcategoriesWithBooks();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $this->bookRepo->update($id, $request->all());

        if (isset($request->image)) {
            $file = $request->image;
            $path = $id . '_' . $file->getClientOriginalName();
            $image = $this->bookRepo->getBookWithRelationsById($id, ['image'])->image;
            $this->imageRepo->update($image->id, ['path' => $path]);
            $file->move(public_path('uploads/books'), $path);
        }

        return redirect()->route('books.index')->with('success', __('messages.update-book-success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userIds = $this->favoriteRepo->getUserIdsByFavoriteBookId($id);
        $book = $this->bookRepo->find($id);

        foreach ($userIds as $user_id) {
            $user = $this->userRepo->find($user_id);
            Notification::send($user, new FavoriteBookNotification($user, $book));
        }
        $this->bookRepo->delete($id);

        return redirect()->route('books.index')->with('success', __('messages.delete-book-success'));
    }

    public function searchByCategory($category_id)
    {
        $category = $this->categoryRepo->find($category_id);
        $books = $this->bookRepo->searchBooksByCategoryId($category_id);
        $categoryChildren = session('categoryChildren');

        if (Auth::check()) {
            $likes = $this->likeRepo->getLikedBookIdsByUserId(Auth::id());
            $favorites = $this->favoriteRepo->getFavoriteBookIdsByUserId(Auth::id());

            return view('user.search_book', compact([
                'category',
                'books',
                'likes',
                'favorites',
                'categoryChildren',
            ]));
        } else {
            return view('user.search_book', compact([
                'category',
                'books',
                'categoryChildren',
            ]));
        }
    }

    public function getDetail($id)
    {
        $book = $this->bookRepo->getBookWithRelationsById($id, ['category', 'image', 'likes']);
        $reviews = $this->reviewRepo->getReviewsWithUsersAndCommentsAndLikesByBookId($id);
        
        $avarageRating = 0;
        $totalReviewDisplay = 0;
        if (count($reviews)) {
            $totalRate = 0;
            foreach ($reviews as $review) {
                if ($review['display'] == config('app.display')) {
                    $totalRate += $review['rate'];
                    $totalReviewDisplay += 1;
                }
            }
            if ($totalReviewDisplay > 0) {
                $avarageRating = round($totalRate/$totalReviewDisplay, config('app.two-decimal'));
            }
        }

        if (Auth::check()) {
            $likedBook = false;
            $favoritedBook = false;
            if (count($this->likeRepo->getLikeOfUserForBook($id, Auth::id()))) {
                $likedBook = true;
            }
            if (count($this->favoriteRepo->getFavoriteOfUserForBook($id, Auth::id()))) {
                $favoritedBook = true;
            }

            return view('book-detail', compact([
                'book',
                'likedBook',
                'favoritedBook',
                'reviews',
                'totalReviewDisplay',
                'avarageRating',
            ]));
        }

        return view('book-detail', compact([
            'book',
            'reviews',
            'totalReviewDisplay',
            'avarageRating',
        ]));
    }

    public function searchByTitle(Request $request)
    {
        $title = $request->title;
        $books = $this->bookRepo->searchBooksByTitle($title);
        $categoryChildren = session('categoryChildren');

        if (Auth::check()) {
            $likes = $this->likeRepo->getLikedBookIdsByUserId(Auth::id());
            $favorites = $this->favoriteRepo->getFavoriteBookIdsByUserId(Auth::id());

            return view('user.index', compact([
                'title',
                'books',
                'likes',
                'favorites',
                'categoryChildren',
            ]));
        } else {
            return view('user.index', compact([
                'title',
                'books',
                'categoryChildren',
            ]));
        }
    }
}
