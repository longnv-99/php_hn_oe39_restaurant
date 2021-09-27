<?php

namespace App\Repositories\Review;

use App\Repositories\RepositoryInterface;

interface ReviewRepositoryInterface extends RepositoryInterface
{
    public function getReviewsHistoryByUserId($user_id);

    public function getReviewsWithUsersAndCommentsAndLikesByBookId($book_id);

    public function hideReviewById($id);

    public function showReviewById($id);
}
