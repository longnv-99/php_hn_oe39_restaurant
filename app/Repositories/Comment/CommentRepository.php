<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel()
    {
        return Comment::class;
    }

    public function hideCommentById($id)
    {
        return $this->update($id, [
            'display' => config('app.non-display'),
        ]);
    }

    public function showCommentById($id)
    {
        return $this->update($id, [
            'display' => config('app.display'),
        ]);
    }

    public function hideCommentsByReviewId($review_id)
    {
        return $this->model->where('review_id', $review_id)
            ->update(['display' => config('app.non-display')]);
    }

    public function showCommentsByReviewId($review_id)
    {
        return $this->model->where('review_id', $review_id)
            ->update(['display' => config('app.display')]);
    }
}
