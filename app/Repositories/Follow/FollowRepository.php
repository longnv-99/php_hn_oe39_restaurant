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

    public function prepareGetRelationship($follower_id, $followed_id)
    {
        return $this->model
            ->where('follower_id', $follower_id)
            ->where('followed_id', $followed_id);
    }
    public function getRelationship($follower_id, $followed_id)
    {
        return $this->prepareGetRelationship($follower_id, $followed_id)->get();
    }

    public function getRelationshipWithTrashed($follower_id, $followed_id)
    {
        return $this->prepareGetRelationship($follower_id, $followed_id)
            ->withTrashed()
            ->get();
    }

    public function restoreRelationship($follower_id, $followed_id)
    {
        return $this->prepareGetRelationship($follower_id, $followed_id)
            ->withTrashed()
            ->restore();
    }

    public function deleteRelationship($follower_id, $followed_id)
    {
        return $this->prepareGetRelationship($follower_id, $followed_id)
            ->delete();
    }
}
