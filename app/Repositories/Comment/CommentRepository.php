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

    public function hideComment($id)
    {
        return $this->update($id, [
            'display' => config('app.non-display'),
        ]);
    }

    public function showComment($id)
    {
        return $this->update($id, [
            'display' => config('app.display'),
        ]);
    }
}
