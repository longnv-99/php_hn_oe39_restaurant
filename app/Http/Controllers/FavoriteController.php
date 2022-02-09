<?php

namespace App\Http\Controllers;

use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Favorite\FavoriteRepositoryInterface;
use App\Repositories\Like\LikeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    protected $favoriteRepo;
    protected $bookRepo;
    protected $likeRepo;

    public function __construct(
        FavoriteRepositoryInterface $favoriteRepo,
        BookRepositoryInterface $bookRepo,
        LikeRepositoryInterface $likeRepo
    ) {
        $this->favoriteRepo = $favoriteRepo;
        $this->bookRepo = $bookRepo;
        $this->likeRepo = $likeRepo;
    }

    public function store(Request $request)
    {
        $this->favoriteRepo->create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
        ]);

        return json_encode(['statusCode' => 200]);
    }

    public function destroy($book_id)
    {
        $this->favoriteRepo->forceDeleteFavorite($book_id, Auth::id());

        return json_encode(['statusCode' => 200]);
    }

    public function index()
    {
        $books = $this->bookRepo->getFavoriteBooksByUserId(Auth::id());
        $likes = $this->likeRepo->getLikedBookIdsByUserId(Auth::id());
        $categoryChildren = session('categoryChildren');

        return view('user.favorite_books', compact('books', 'likes', 'categoryChildren'));
    }
}
