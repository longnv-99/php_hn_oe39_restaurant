<?php

namespace App\Repositories\Review;

use App\Repositories\RepositoryInterface;

interface ReviewRepositoryInterface extends RepositoryInterface
{
    public function getReviewsHistory($id);
}
