<?php

namespace App\Repositories\Follow;

use App\Repositories\RepositoryInterface;

interface FollowRepositoryInterface extends RepositoryInterface
{
    public function prepareGetRelationship($follower_id, $followed_id);

    public function getRelationship($follower_id, $followed_id);

    public function getRelationshipWithTrashed($follower_id, $followed_id);

    public function restoreRelationship($follower_id, $followed_id);

    public function deleteRelationship($follower_id, $followed_id);
}
