<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Like;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = Book::with('image')
            ->addSelect([
                'total_like' => Like::select(DB::raw('count(*)'))
                ->whereColumn('books.id', 'likes.likeable_id')
                ->where('likeable_type', 'App\Models\Book'),
                'total_review' => Review::select(DB::raw('count(*)'))
                ->whereColumn('books.id', 'reviews.book_id'),
                'total_rate' => Review::select(DB::raw('sum(rate)'))
                ->whereColumn('books.id', 'reviews.book_id'),
            ])->get();

        $categoryParents = Category::all()->where('parent_id', '=', config('app.category_parent_id'));
        $categoryChildren = Category::all()->where('parent_id', '!=', config('app.category_parent_id'));

        session([
            'categoryParents' => $categoryParents,
            'categoryChildren' => $categoryChildren,
        ]);

        if (Auth::check()) {
            $likes = Like::where('user_id', Auth::id())
                ->where('likeable_type', 'App\Models\Book')
                ->pluck('likeable_id')
                ->toArray();

            $favorites = Favorite::where('user_id', Auth::id())->pluck('book_id')->toArray();

            return view('user.index', compact('books', 'likes', 'favorites', 'categoryParents', 'categoryChildren'));
        } else {
            return view('user.index', compact('books', 'categoryParents', 'categoryChildren'));
        }
    }

    public function changeLanguage($lang)
    {
        $language = ($lang == 'vi' || $lang == 'en') ? $lang : config('app.locale');
        Session::put('language', $language);

        return redirect()->back();
    }
}
