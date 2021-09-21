<?php

namespace App\Http\Controllers;

use App\Repositories\Like\LikeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeRepository;

    public function __construct(LikeRepositoryInterface $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function store(Request $request)
    {
        $book_id = $request->book_id;

        $data = [
            'user_id' => Auth::id(),
            'likeable_id' => $book_id,
            'likeable_type' => 'App\Models\Book',
        ];
        $this->likeRepository->create($data);

        return json_encode(['statusCode' => 200]);
    }

    public function destroy($book_id)
    {
        $this->likeRepository->dislikeBook($book_id, Auth::id());

        return json_encode(['statusCode' => 200]);
    }
}
