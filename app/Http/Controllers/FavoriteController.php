<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Like;
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
            'user_id' => Auth::user()->id,
            'book_id' => $book_id,
        ]);

        return json_encode(['statusCode' => 200]);
    }

    public function destroy($book_id)
    {
        $book = Book::findOrFail($book_id);
        Favorite::withTrashed()
            ->where('user_id', Auth::user()->id)
            ->where('book_id', $book_id)
            ->forceDelete();

        return json_encode(['statusCode' => 200]);
    }

    public function index()
    {
        $books = Book::with('image')
            ->join('favorites', 'favorites.book_id', 'books.id')
            ->where('user_id', Auth::user()->id)
            ->addSelect(['total_like' => Like::select(DB::raw('count(*)'))
            ->whereColumn('books.id', 'likes.likeable_id')
            ->where('likeable_type', 'App\Models\Book')])
            ->get();

        $likes = Like::where('user_id', Auth::user()->id)
            ->where('likeable_type', 'App\Models\Book')
            ->pluck('likeable_id')
            ->toArray();

        $categoryParents = Category::all()->where('parent_id', '=', config('app.category_parent_id'));
        $categoryChildren = Category::all()->where('parent_id', '!=', config('app.category_parent_id'));
    
        return view('user.favorite_books', compact('books', 'likes', 'categoryParents', 'categoryChildren'));
    }
}
