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

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $book_id = $request->book_id;
        $book = Book::findOrFail($book_id);
        Favorite::create([
            'user_id' => Auth::id(),
            'book_id' => $book_id,
        ]);

        return json_encode(['statusCode' => 200]);
    }

    public function destroy($book_id)
    {
        $book = Book::findOrFail($book_id);
        Favorite::withTrashed()
            ->where('user_id', Auth::id())
            ->where('book_id', $book_id)
            ->forceDelete();

        return json_encode(['statusCode' => 200]);
    }

    public function index()
    {
        $books = Book::with('image')
            ->join('favorites', 'favorites.book_id', 'books.id')
            ->where('user_id', Auth::id())
            ->addSelect([
                'total_like' => Like::select(DB::raw('count(*)'))
                ->whereColumn('books.id', 'likes.likeable_id')
                ->where('likeable_type', 'App\Models\Book'),
                'total_review' => Review::select(DB::raw('count(*)'))
                ->whereColumn('books.id', 'reviews.book_id'),
                'total_rate' => Review::select(DB::raw('sum(rate)'))
                ->whereColumn('books.id', 'reviews.book_id'),
            ])->get();

        $likes = Like::where('user_id', Auth::id())
            ->where('likeable_type', 'App\Models\Book')
            ->pluck('likeable_id')
            ->toArray();

        $categoryParents = Category::all()->where('parent_id', '=', config('app.category_parent_id'));
        $categoryChildren = Category::all()->where('parent_id', '!=', config('app.category_parent_id'));
    
        return view('user.favorite_books', compact('books', 'likes', 'categoryParents', 'categoryChildren'));
    }
}
