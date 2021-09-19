<?php

namespace App\Repositories\Follow;

use App\Repositories\RepositoryInterface;

interface FollowRepositoryInterface extends RepositoryInterface
{
    public function getRelationship($id);
}
