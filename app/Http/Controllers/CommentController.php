<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\EditCommentRequest;
use Illuminate\Support\Facades\Auth;

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
        $data['user_id'] = Auth::id();
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
    public function update(EditCommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $comment->update($data);

        return redirect()->back()->with('success', __('messages.edit-comment-success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->back()->with('success', __('messages.delete-comment-success'));
    }

    public function hide($id)
    {
        Comment::findOrFail($id)->update(['display' => config('app.non-display')]);

        return response()->json(['success' => __('messages.hide-comment-success')]);
    }

    public function view($id)
    {
        Comment::findOrFail($id)->update(['display' => config('app.display')]);

        return response()->json(['success' => __('messages.show-comment-success')]);
    }
}
