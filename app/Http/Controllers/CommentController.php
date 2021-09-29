<?php

namespace App\Http\Controllers;

use App\Repositories\Comment\CommentRepositoryInterface;
use App\Models\Comment;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\EditCommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(CommentRepositoryInterface $commentRepo)
    {
        $this->commentRepo = $commentRepo;
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
        $this->commentRepo->create($data);

        return redirect()->back()->with('success', __('messages.create-comment-success'));
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
        $this->commentRepo->update($comment->id, $request->all());

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
        $this->commentRepo->delete($comment->id);

        return redirect()->back()->with('success', __('messages.delete-comment-success'));
    }

    public function hide($id)
    {
        $this->commentRepo->hideCommentById($id);

        return response()->json(['success' => __('messages.hide-comment-success')]);
    }

    public function view($id)
    {
        $this->commentRepo->showCommentById($id);

        return response()->json(['success' => __('messages.show-comment-success')]);
    }
}
