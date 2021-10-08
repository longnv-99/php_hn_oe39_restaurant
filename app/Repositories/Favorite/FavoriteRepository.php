<?php

namespace App\Repositories\Favorite;

use App\Models\Favorite;
use App\Repositories\BaseRepository;

class FavoriteRepository extends BaseRepository implements FavoriteRepositoryInterface
{
    public function getModel()
    {
        return Favorite::class;
    }

    public function getFavoriteBookIdsByUserId($user_id)
    {
        return $this->model->where('user_id', $user_id)
            ->pluck('book_id')->toArray();
    }

    public function getUserIdsByFavoriteBookId($book_id)
    {
        return $this->model->where('book_id', $book_id)
            ->pluck('user_id')->toArray();
    }

    public function getUserIdsMarkFavorite()
    {
        return $this->model->distinct()
            ->pluck('user_id')->toArray();
    }

    public function getFavoriteOfUserForBook($book_id, $user_id)
    {
        return $this->model->where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->get();
    }

    public function forceDeleteFavorite($book_id, $user_id)
    {
        return $this->model->withTrashed()
            ->where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->forceDelete();
    }
}
