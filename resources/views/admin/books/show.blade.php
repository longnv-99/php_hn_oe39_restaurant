@extends('admin.layouts.layout')

@section('title', __('messages.book-detail'))
@section('main')
<section class="content">
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="col-12">
                        <img src="{{ asset('uploads/books/' . $book->image->path) }}" class="product-image">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">{{ $book->title }}</h3>
                    <p>{{ __('messages.category') }} : {{ $book->category->name }}</p>
                    <p>{{ __('messages.author') }} : {{ $book->author }}</p>
                    <p>{{ __('messages.publish-date') }} : {{ $book->published_date }}</p>
                    <p>{{ __('messages.number-of-page') }} : {{ $book->number_of_page }}</p>
                    <p>{{ __('messages.created-at') }} : {{ $book->created_at }}</p>
                    <p>{{ __('messages.updated-at') }} : {{ $book->updated_at }}</p>
                    <hr>
                    <div class="mt-4">
                        <a href="{{ route('books.edit', $book) }}">
                            <div class="btn btn-primary btn-lg btn-flat">
                                <i class="fas fa-edit fa-lg mr-2"></i>
                                {{ __('messages.update-book') }}
                            </div>
                        </a>
                        <button class="btn btn-default btn-lg btn-flat" data-toggle="modal" data-target="#confirmModal">
                            <i class="fas fa-trash-alt fa-lg mr-2"></i>
                            {{ __('messages.delete-book') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5 mt-5">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center mb-5" id="list-review-comment">{{ __('messages.list-review-comment') }}</h3>
                            @foreach ($reviews as $review)
                                <span hidden class="review-display">{{ $review->display }}</span>
                                <div class="media mt-4">
                                    <img id="user-img" class="mr-3 rounded-circle" alt="User Review" src="{{ asset('uploads/users/' . $review->user->image->path) }}" />
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <h5>{{ $review->user->username }}</h5>
                                                <span class="text-muted">{{ formatOutputDate($review->updated_at) }}</span>
                                                <div>
                                                    <span>{{ $review->rate }}&#11088;</span>
                                                    <span>{{ count($review->comments) }} {{ __('messages.comment') }}</span>
                                                    <a href="{{ route('reviews.hide', $review) }}" class="badge badge-danger rv-hide" id="{{ $review->id }}">{{ __('messages.hide') }}</a>
                                                    <a href="{{ route('reviews.view', $review) }}" class="badge badge-primary rv-show" id="{{ $review->id }}">{{ __('messages.show') }}</a>
                                                    <span class="rv-success" id="{{ $review->id }}"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="review-content" id="{{ $review->id }}">{{ $review->content }}</span>
                                        @foreach ($review->comments as $comment)
                                            <span hidden class="comment-display">{{ $comment->display }}</span>
                                            <div class="media mt-3">
                                                <img id="user-img" class="rounded-circle" alt="User Comment" src="{{ asset('uploads/users/' . $comment->user->image->path) }}" />
                                                <div class="media-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5>{{ $comment->user->username }}</h5>
                                                            <div>
                                                                <a href="{{ route('comments.hide', $comment) }}" class="badge badge-danger cmt-hide cmt-hide-rv-{{ $comment->review_id }}" id="{{ $comment->id }}">{{ __('messages.hide') }}</a>
                                                                <a href="{{ route('comments.view', $comment) }}" class="badge badge-primary cmt-show cmt-show-rv-{{ $comment->review_id }}" id="{{ $comment->id }}">{{ __('messages.show') }}</a>
                                                                <span class="cmt-success" id="{{ $comment->id }}"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="comment-content cmt-content-rv-{{ $comment->review_id }}" id="{{ $comment->id }}">{{ $comment->content }}</span>
                                                </div>
                                            </div>
                                        @endforeach    
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- confirm modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.confirm') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('messages.confirm-message') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.cancel') }}</button>
                <form action="{{ route('books.destroy', $book) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-primary">{{ __('messages.ok') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script src="{{ asset('js/manage_review_comment.js') }}"></script>

@endsection
