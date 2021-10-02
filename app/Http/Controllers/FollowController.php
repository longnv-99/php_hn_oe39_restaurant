<?php

namespace App\Http\Controllers;

use App\Notifications\FollowNotification;
use App\Repositories\Follow\FollowRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    protected $followRepo;
    protected $userRepo;

    public function __construct(FollowRepositoryInterface $followRepo, UserRepositoryInterface $userRepo)
    {
        $this->followRepo = $followRepo;
        $this->userRepo = $userRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $relationship = $this->followRepo
            ->getRelationshipWithTrashed(Auth::id(), $request->id);
        if ($relationship->isEmpty()) {
            $this->followRepo->create([
                'follower_id' => Auth::id(),
                'followed_id' => $request->id,
            ]);
        } else {
            $this->followRepo->restoreRelationship(Auth::id(), $request->id);
        }

        $followed_user = $this->userRepo->find($request->id);
        $followed_user->notify(new FollowNotification(Auth::user(), $followed_user));

        return json_encode(['statusCode' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->followRepo->deleteRelationship(Auth::id(), $id);

        return json_encode(['statusCode' => 200]);
    }
}
