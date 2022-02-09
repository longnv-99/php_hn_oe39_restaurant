<?php

namespace App\Repositories\Like;

use App\Repositories\RepositoryInterface;

interface LikeRepositoryInterface extends RepositoryInterface
{
    public function dislikeBookOrReview($likeable_id, $likeable_type, $user_id);

    public function getLikedBookIdsByUserId($user_id);

    public function getLikeOfUserForBook($book_id, $user_id);

    public function getLikeOfUserForReview($review_id, $user_id);
}
