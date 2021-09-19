<?php

namespace App\Repositories\Follow;

use App\Models\Follow;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class FollowRepository extends BaseRepository implements FollowRepositoryInterface
{
    public function getModel()
    {
        return Follow::class;
    }

    public function getRelationship($id)
    {
        return $this->model
            ->where('follower_id', Auth::id())
            ->where('followed_id', $id)
            ->get();
    }
}
