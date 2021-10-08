<?php

namespace App\Repositories\Favorite;

use App\Repositories\RepositoryInterface;

interface FavoriteRepositoryInterface extends RepositoryInterface
{
    public function getFavoriteBookIdsByUserId($user_id);

    public function getUserIdsByFavoriteBookId($book_id);

    public function getUserIdsMarkFavorite();

    public function getFavoriteOfUserForBook($book_id, $user_id);

    public function forceDeleteFavorite($book_id, $user_id);
}
