<?php

namespace App\Repositories\Like;

use App\Models\Like;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class LikeRepository extends BaseRepository implements LikeRepositoryInterface
{
    public function getModel()
    {
        return Like::class;
    }

    public function dislikeBook($book_id, $user_id)
    {
        return $this->model
            ->withTrashed()
            ->where('user_id', $user_id)
            ->where('likeable_id', $book_id)
            ->where('likeable_type', 'App\Models\Book')
            ->forceDelete();
    }
}
