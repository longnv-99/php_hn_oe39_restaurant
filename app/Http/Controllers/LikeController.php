<?php

namespace App\Http\Controllers;

use App\Repositories\Like\LikeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeRepo;

    public function __construct(LikeRepositoryInterface $likeRepo)
    {
        $this->likeRepo = $likeRepo;
    }

    public function store(Request $request)
    {
        $book_id = $request->book_id;

        $data = [
            'user_id' => Auth::id(),
            'likeable_id' => $book_id,
            'likeable_type' => 'App\Models\Book',
        ];
        $this->likeRepo->create($data);

        return json_encode(['statusCode' => 200]);
    }

    public function destroy($book_id)
    {
        $this->likeRepo->dislikeBookOrReview($book_id, 'App\Models\Book', Auth::id());

        return json_encode(['statusCode' => 200]);
    }
}
