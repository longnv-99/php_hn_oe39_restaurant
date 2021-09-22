<?php

namespace App\Repositories\Comment;

use App\Repositories\RepositoryInterface;

interface CommentRepositoryInterface extends RepositoryInterface
{
    public function hideComment($id);

    public function showComment($id);
}
