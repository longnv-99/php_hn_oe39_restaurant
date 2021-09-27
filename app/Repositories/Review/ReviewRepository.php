<?php

namespace App\Repositories\Review;

use App\Models\Review;
use App\Repositories\BaseRepository;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function getModel()
    {
        return Review::class;
    }

    public function getReviewsHistoryByUserId($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->where('display', config('app.display'))
            ->orderBy('updated_at', 'DESC')
            ->paginate(config('app.paginate'));
    }

    public function getReviewsWithUsersAndCommentsAndLikesByBookId($book_id)
    {
        return $this->model->with('user', 'comments', 'likes')
            ->where('book_id', $book_id)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    public function hideReviewById($id)
    {
        return $this->update($id, ['display' => config('app.non-display')]);
    }

    public function showReviewById($id)
    {
        return $this->update($id, ['display' => config('app.display')]);
    }
}
