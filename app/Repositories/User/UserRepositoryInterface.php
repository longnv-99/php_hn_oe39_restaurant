<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getUsersIsNotAdmin();

    public function showUserProfile($id);

    public function changeUserStatus($id, $status);
}
