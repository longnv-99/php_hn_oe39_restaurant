<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Image;
use App\Models\Like;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with(['category', 'image'])->orderBy('updated_at', 'DESC')->paginate(config('app.paginate'));

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereNotIn('id', Category::distinct()->pluck('parent_id')->toArray())->get();
        
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
        $book = Book::create($data);

        $file = $data['image'];
        $image = [];
        $image['imageable_type'] = get_class($book);
        $image['imageable_id'] = $book->id;
        $image['path'] = $book->id . '_' . $file->getClientOriginalName();

        Image::create($image);
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
        $book = Book::with(['category', 'image'])->findOrFail($id);
        $reviews = Review::with('user.image', 'comments')->where('book_id', $id)->get();

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
        $book = Book::with(['category', 'image'])->findOrFail($id);
        $categories = Category::whereNotIn('id', Category::distinct()->pluck('parent_id')->toArray())->get();

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
        $book = Book::with('image')->findOrFail($id);
        $book->update($request->all());
        if (isset($request->image)) {
            $file = $request->image;
            $path = $id . '_' . $file->getClientOriginalName();
            Image::where('id', $book->image->id)->update(['path' => $path]);
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
        $book = Book::findOrFail($id);
        $book->delete();
        $book->image->delete();

        return redirect()->route('books.index')->with('success', __('messages.delete-book-success'));
    }

    public function searchByCategory($category_id)
    {
        $category = Category::findOrFail($category_id);

        $books = Book::with('image')
            ->where('category_id', $category_id)
            ->addSelect(['total_like' => Like::select(DB::raw('count(*)'))
            ->whereColumn('books.id', 'likes.likeable_id')
            ->where('likeable_type', 'App\Models\Book')])
            ->get();

        $likes = Like::where('user_id', Auth::user()->id)
            ->where('likeable_type', 'App\Models\Book')
            ->pluck('likeable_id')
            ->toArray();

        $favorites = Favorite::where('user_id', Auth::user()->id)->pluck('book_id')->toArray();

        $categoryParents = session('categoryParents');
        $categoryChildren = session('categoryChildren');
    
        return view('user.search_book', compact([
            'category',
            'books',
            'likes',
            'favorites',
            'categoryParents',
            'categoryChildren',
        ]));
    }

    public function getDetail($id)
    {
        $book = Book::with(['category', 'image', 'likes'])->findOrFail($id);
        $reviews = Review::with('comments', 'user', 'likes')
            ->where('book_id', '=', $id)
            ->orderBy('updated_at', 'DESC')
            ->get();
        
        $avarageRating = 0;
        if (count($reviews)) {
            $totalScore = 0;
            foreach ($reviews as $review) {
                $totalScore += $review['rate'];
            }
            $avarageRating = round($totalScore/count($reviews), config('app.two-decimal'));
        }

        return view('book-detail', compact('book', 'reviews', 'avarageRating'));
    }

    public function searchByTitle(Request $request)
    {
        $title = $request->title;

        $books = Book::with('image')
            ->where('title', 'like', '%' . $title . '%')
            ->addSelect(['total_like' => Like::select(DB::raw('count(*)'))
            ->whereColumn('books.id', 'likes.likeable_id')
            ->where('likeable_type', 'App\Models\Book')])
            ->get();

        $likes = Like::where('user_id', Auth::user()->id)
            ->where('likeable_type', 'App\Models\Book')
            ->pluck('likeable_id')
            ->toArray();

        $favorites = Favorite::where('user_id', Auth::user()->id)->pluck('book_id')->toArray();

        $categoryParents = session('categoryParents');
        $categoryChildren = session('categoryChildren');

        return view('user.index', compact([
            'books',
            'title',
            'likes',
            'favorites',
            'categoryParents',
            'categoryChildren',
        ]));
    }
}
