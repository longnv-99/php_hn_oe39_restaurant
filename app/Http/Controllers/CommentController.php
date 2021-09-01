<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\EditCommentRequest;

class CommentController extends Controller
{
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
    public function store(CreateCommentRequest $request)
    {
        $data = $request->all();
        $data['display'] = config('app.display');
        Comment::create($data);

        return redirect()->back()->with('success', __('messages.create-comment-success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(EditCommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $user_id = $comment->user_id;
        if (checkValidUser($user_id)) {
            $comment->update($request->all());
        } else {
            redirect()->back()->with('error', __('messages.unauthorize'));
        }

        return redirect()->back()->with('success', __('messages.edit-comment-success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $user_id = $comment->user_id;
        if (checkValidUser($user_id)) {
            $comment->delete();
        } else {
            redirect()->back()->with('error', __('messages.unauthorize'));
        }

        return redirect()->back()->with('success', __('messages.delete-comment-success'));
    }
}
