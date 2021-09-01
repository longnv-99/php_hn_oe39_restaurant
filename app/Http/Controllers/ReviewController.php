<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\EditReviewRequest;

class ReviewController extends Controller
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
    public function store(CreateReviewRequest $request)
    {
        $data = $request->all();
        $data['display'] = config('app.display');
        Review::create($data);

        return redirect()->back()->with('success', __('messages.create-review-success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(EditReviewRequest $request, $id)
    {
        $review = Review::findOrFail($id);
        $user_id = $review->user_id;
        if (checkValidUser($user_id)) {
            $review->update($request->all());
        } else {
            redirect()->back()->with('error', __('messages.unauthorize'));
        }

        return redirect()->back()->with('success', __('messages.edit-review-success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $user_id = $review->user_id;
        if (checkValidUser($user_id)) {
            $review->delete();
        } else {
            redirect()->back()->with('error', __('messages.unauthorize'));
        }

        return redirect()->back()->with('success', __('messages.delete-review-success'));
    }
}
