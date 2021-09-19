<?php

namespace App\Repositories\User;

use App\Models\Follow;
use App\Models\Review;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUsersIsNotAdmin()
    {
        return $this->model
            ->orderBy('updated_at', 'DESC')
            ->where('role_id', config('app.user_role_id'))
            ->paginate(config('app.paginate'));
    }

    public function showUserProfile($id)
    {
        $user = $this->model
            ->with(['followers.followed.image'])
            ->withCount('followers as number_of_follower')
            ->with(['followeds.follower.image'])
            ->withCount('followeds as number_of_followed')
            ->findOrFail($id);
        $user->dob = formatOutputDate($user->dob);
        
        return $user;
    }

    public function changeUserStatus($id, $status)
    {
        if ($status == config('app.is_active')) {
            return $this->update($id, ['is_active' => config('app.is_inactive')]);
        } else {
            return $this->update($id, ['is_active' => config('app.is_active')]);
        }
    }
}
