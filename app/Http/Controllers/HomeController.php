<?php

namespace App\Http\Controllers;

use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Favorite\FavoriteRepositoryInterface;
use App\Repositories\Like\LikeRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    protected $bookRepo;
    protected $categoryRepo;
    protected $likeRepo;
    protected $favoriteRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BookRepositoryInterface $bookRepo,
        CategoryRepositoryInterface $categoryRepo,
        LikeRepositoryInterface $likeRepo,
        FavoriteRepositoryInterface $favoriteRepo
    ) {
        $this->bookRepo = $bookRepo;
        $this->categoryRepo = $categoryRepo;
        $this->likeRepo = $likeRepo;
        $this->favoriteRepo = $favoriteRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = $this->bookRepo->getAllBooksWithImagesAndLikesAndRates();
        $categoryChildren = $this->categoryRepo->getAllSubcategoriesWithBooks();
        session(['categoryChildren' => $categoryChildren]);

        if (Auth::check()) {
            $likes = $this->likeRepo->getLikedBookIdsByUserId(Auth::id());
            $favorites = $this->favoriteRepo->getFavoriteBookIdsByUserId(Auth::id());

            return view('user.index', compact('books', 'likes', 'favorites', 'categoryChildren'));
        } else {
            return view('user.index', compact('books', 'categoryChildren'));
        }
    }

    public function changeLanguage($lang)
    {
        $language = ($lang == 'vi' || $lang == 'en') ? $lang : config('app.locale');
        Session::put('language', $language);

        return redirect()->back();
    }
}
