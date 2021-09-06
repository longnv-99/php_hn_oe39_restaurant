<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Follow;
use App\Models\Like;
use App\Models\User;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('updated_at', 'DESC')
            ->where('role_id', config('app.user_role_id'))
            ->paginate(config('app.paginate'));

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /**get following and follower of user */
        $user = User::with(['followers.followed.image'])
            ->withCount('followers as number_of_follower')
            ->with(['followeds.follower.image'])
            ->withCount('followeds as number_of_followed')
            ->findOrFail($id);

        $relationship = Follow::where('follower_id', Auth::id())
            ->where('followed_id', $id)
            ->whereNull('deleted_at')
            ->get();

        return view('user.profile', compact('user', 'relationship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();

            return redirect()->route('users.index')->with('success', __('messages.delete-user-success'));
        } catch (Exception $ex) {
            return redirect()->route('users.index')->with('error', __('messages.delete-user-failed'));
        }
    }

    public function myProfile()
    {
        $reviewHistory = Review::where('user_id', '=', getAuthUserId())
                        ->where('display', '=', config('app.display'))
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        $user = Auth::user();
        $user->dob = formatOutputDate($user->dob);

        return view('profile', compact(['reviewHistory','user']));
    }

    public function getUserProfile($id)
    {
        $reviewHistory = Review::where('user_id', '=', $id)
                        ->where('display', '=', config('app.display'))
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        $user = User::where('is_active', '=', config('app.is_active'))->with('image')->findOrFail($id);
        $user->dob = formatOutputDate($user->dob);
        
        return view('profile', compact(['reviewHistory','user']));
    }
    
    public function home()
    {
        $books = Book::with('image')->addSelect(['total_like' => Like::select(DB::raw('count(*)'))
            ->whereColumn('books.id', 'likes.likeable_id')
            ->where('likeable_type', 'App\Models\Book')])
            ->get();

        $categoryParents = Category::all()->where('parent_id', '=', config('app.category_parent_id'));
        $categoryChildren = Category::all()->where('parent_id', '!=', config('app.category_parent_id'));
    
        session([
            'categoryParents' => $categoryParents,
            'categoryChildren' => $categoryChildren,
        ]);

        return view('user.index', compact('books', 'categoryParents', 'categoryChildren'));
    }
}
