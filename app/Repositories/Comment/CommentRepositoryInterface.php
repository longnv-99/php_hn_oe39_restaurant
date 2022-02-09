<?php

namespace App\Repositories\Comment;

use App\Repositories\RepositoryInterface;

interface CommentRepositoryInterface extends RepositoryInterface
{
    public function hideCommentById($id);

    public function showCommentById($id);

    public function hideCommentsByReviewId($review_id);

    public function showCommentsByReviewId($review_id);
}
