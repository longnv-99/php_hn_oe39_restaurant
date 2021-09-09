<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $book_id = $request->book_id;
        $book = Book::findOrFail($book_id);
        Like::create([
            'user_id' => Auth::user()->id,
            'likeable_id' => $book_id,
            'likeable_type' => get_class($book),
        ]);

        return json_encode(['statusCode' => 200]);
    }

    public function destroy($book_id)
    {
        $book = Book::findOrFail($book_id);
        Like::withTrashed()
            ->where('user_id', Auth::user()->id)
            ->where('likeable_id', $book_id)
            ->where('likeable_type', get_class($book))
            ->forceDelete();

        return json_encode(['statusCode' => 200]);
    }
}
