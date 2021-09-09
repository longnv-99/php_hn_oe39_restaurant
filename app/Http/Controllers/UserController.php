<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('updated_at', 'DESC')
            ->where('role_id', config('app.user_role_id'))
            ->paginate(config('app.paginate'));

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        /**get following and follower of user */
        $user = User::with(['followers.followed.image'])
            ->withCount('followers as number_of_follower')
            ->with(['followeds.follower.image'])
            ->withCount('followeds as number_of_followed')
            ->findOrFail($id);

        $user->dob = formatOutputDate($user->dob);
        
        $relationship = Follow::where('follower_id', Auth::id())
            ->where('followed_id', $id)
            ->whereNull('deleted_at')
            ->get();

        $reviews = Review::where('user_id', $id)
            ->where('display', config('app.display'))
            ->orderBy('updated_at', 'DESC')
            ->paginate(config('app.paginate'));

        return view('user.profile', compact('user', 'relationship', 'reviews'));
    }

    public function enable($id)
    {
        User::findOrFail($id)->update(['is_active' => config('app.is_active')]);
        
        return redirect()->route('users.index')->with('success', __('messages.enable-user-success'));
    }

    public function disable($id)
    {
        User::findOrFail($id)->update(['is_active' => config('app.is_inactive')]);
        
        return redirect()->route('users.index')->with('success', __('messages.disable-user-success'));
    }
    
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();

            return redirect()->route('users.index')->with('success', __('messages.delete-user-success'));
        } catch (Exception $ex) {
            return redirect()->route('users.index')->with('error', __('messages.delete-user-failed'));
        }
    }
}
