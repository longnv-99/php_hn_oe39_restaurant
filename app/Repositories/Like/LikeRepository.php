<?php

namespace App\Repositories\Like;

use App\Models\Like;
use App\Repositories\BaseRepository;

class LikeRepository extends BaseRepository implements LikeRepositoryInterface
{
    public function getModel()
    {
        return Like::class;
    }

    public function dislikeBookOrReview($likeable_id, $likeable_type, $user_id)
    {
        return $this->model
            ->withTrashed()
            ->where('user_id', $user_id)
            ->where('likeable_id', $likeable_id)
            ->where('likeable_type', $likeable_type)
            ->forceDelete();
    }

    public function getLikedBookIdsByUserId($user_id)
    {
        return $this->model->where('user_id', $user_id)
            ->where('likeable_type', 'App\Models\Book')
            ->pluck('likeable_id')
            ->toArray();
    }

    public function getLikeOfUserForBook($book_id, $user_id)
    {
        return $this->model->where('user_id', $user_id)
            ->where('likeable_type', 'App\Models\Book')
            ->where('likeable_id', $book_id)
            ->get();
    }

    public function getLikeOfUserForReview($review_id, $user_id)
    {
        return $this->model->where('user_id', $user_id)
            ->where('likeable_type', 'App\Models\Review')
            ->where('likeable_id', $review_id)
            ->get();
    }
}
