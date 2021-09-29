@extends('layouts.app')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-6">
            <img src="{{ asset('uploads/books/' . $book->image->path) }}" width="60%" 
     height="auto" class="rounded" alt="">
        </div>
        <div class="col-6">
            <h1 class="my-3">{{ $book->title }}</h1>
            <p>{{ __('messages.category') }} : {{ $book->category->name }}</p>
            <p>{{ __('messages.author') }} : {{ $book->author }}</p>
            <p>{{ __('messages.publish-date') }} : {{ formatOutputDate($book->published_date) }}</p>
            <p>{{ __('messages.number-of-page') }} : {{ $book->number_of_page }}</p>
            <hr>
            <h3>{{ $avarageRating }} / {{ config('app.max-rating')}} <span>&#11088;</span></h3>
            <hr>
            @if (Auth::check())
                <div class="book-action mt-4">
                    @if ($likedBook)
                        <button class="btn btn-primary btn-unlike" id="{{ $book->id }}">
                            <i class="fas fa-thumbs-up"></i>
                            <span id="total-like-{{ $book->id }}">{{ count($book->likes) }}</span>
                        </button>
                    @else
                        <button class="btn btn-outline-primary btn-like" id="{{ $book->id }}">
                            <i class="fas fa-thumbs-up"></i>
                            <span id="total-like-{{ $book->id }}">{{ count($book->likes) }}</span>
                        </button>
                    @endif
                    @if ($favoritedBook)
                        <button class="btn btn-danger btn-unmark-favorite" id="{{ $book->id }}">
                            <i class="fas fa-heart"></i>
                            <span>{{ __('messages.favorite') }}</span>
                        </button>
                    @else
                        <button class="btn btn-outline-danger btn-mark-favorite" id="{{ $book->id }}">
                            <i class="fas fa-heart"></i>
                            <span>{{ __('messages.favorite') }}</span>
                        </button>
                    @endif
                </div>
            @else
                <div class="book-action mt-4">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-thumbs-up"></i>
                        <span>{{ count($book->likes) }}</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
		<div class="container mt-2">
			<div class="row d-flex justify-content-center">
				<div class="card-body p-4  rounded">
					<div class="d-flex flex-start w-100">
						@if (Auth::check())
							<img
								class="review-thumbnail rounded-circle shadow-1-strong mr-2"
								src="{{ asset('uploads/users/' . Auth::user()->image->path) }}"
								alt="avatar"
							/>
						@else 
							<img
								class="review-thumbnail rounded-circle shadow-1-strong  mr-2"
								src="{{ asset('uploads/users/' . config('app.default_avatar_path')) }}"
								alt="avatar"
							/>
						@endif
						<div class="w-100">
							<h4>{{ __('messages.leave-a-review') }}</h4>
							<form method="POST" action="{{ route('reviews.store') }}">
						        @csrf
								<div class="rate">
            						@for ($i = config('app.max-rating'); $i >= config('app.one-star'); $i--)
										<input type="radio" id="star{{ $i }}" name="rate" value={{ $i }} />
										<label for="star{{ $i }}" title="text">{{ $i }} stars</label>
									@endfor
								</div>
								<div class="form-outline">
									<textarea class="form-control border border-info" placeholder="{{ __('messages.leave-a-review') }}" name="content" rows="4">
            						</textarea>
								</div>
            					<input type="hidden" name="book_id" value={{ $book->id }}>
								<button type="submit" class="btn btn-primary float-right mt-1">
									{{ __('messages.review') }}
									<i class="fas fa-long-arrow-alt-right ms-1"></i>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
    <div class="d-flex align-items-center justify-content-center mt-2">
		<div class="container">
			<div class="row justify-content-center ">
				<div class="col-lg-12 mb-2">
					<h1>{{ $totalReviewDisplay }} {{ __('messages.review') }}</h1>
				</div>
			</div>
			<div class="row justify-content-center mb-4">
				<div class="col-lg-12">
					<div class="comments">
					@foreach ($reviews as $review)
						@if ($review->display == config('app.display'))
						<div class="comment d-flex mb-4">
							<div class="flex-shrink-0">
								<div class="avatar avatar-sm rounded-circle">
									<img id="user-img" class="avatar-img" src="{{ asset('uploads/users/' . $review->user->image->path) }}" alt="">
								</div>
							</div>
							<div class="flex-grow-1 ms-2 ms-sm-3">
								<div class="comment-meta d-flex align-items-baseline">
									<h6 class="ml-2 mr-2">
									<a href="{{ route('users.show', $review->user) }}">
										{{ $review->user->username }}
									</a>  
									</h6>
									<span class="text-muted">{{ formatOutputDate($review->updated_at) }}</span>
								</div>
								<div class="comment-body ml-2">
									<p>{{ $review->rate }} <span>&#11088;</span> . {{ $review->content }}</p>
									<p>
										<a class="mr-2" href="{{ route('reviews.rate', $review) }}">
										{{ count($review->likes) }} <i class="far fa-thumbs-up"></i>
										</a>
										<a class="mr-2" data-toggle="collapse" href="#collapseExample{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
											{{ __('messages.comment') }}
										</a>
										<a class="mr-2" data-toggle="collapse" href="#editReview{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
											{{ __('messages.edit') }}
										</a>
										<a class="mr-2" data-toggle="collapse" href="#deleteReview{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
											{{ __('messages.delete') }}
										</a>
									</p>
									<div class="collapse" id="collapseExample{{ $review->id }}">
									<form method="POST" action="{{ route('comments.store') }}">
										@csrf
										<textarea class="form-control" placeholder="{{ __('messages.leave-a-comment') }}" name="content" rows="3">
										</textarea>
										<input type="hidden" name="review_id" value={{ $review->id }}>
										<button type="submit" class="btn btn-primary mt-2 float-right">{{ __('messages.comment') }}</button>
										<button class="btn btn-danger float-right mt-2 mr-2" type="button" data-toggle="collapse" data-target="#collapseExample{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
										{{ __('messages.cancel') }}
										</button>
									</form>
									</div>
									<div class="collapse" id="deleteReview{{ $review->id }}">
										<form action="{{ route('reviews.destroy', $review->id) }}" method="post">
											@csrf
											@method('DELETE')
											<h3>{{ __('messages.delete_confirm') }}</h3>
											<button type="submit" class="btn btn-warning float-left mr-2 mb-2 ">
												{{ __('messages.delete') }}
											</button>
											<button class="btn btn-danger float-left mr-2 mb-2" type="button" data-toggle="collapse" data-target="#deleteReview{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
												{{ __('messages.cancel') }}
											</button>
										</form>
									</div>
									<div class="collapse" id="editReview{{ $review->id }}">
									<form method="POST" action="{{ route('reviews.update', $review->id) }}">
										@csrf
										@method('PUT')
										<div class="form-group">
											<label>{{ __('messages.rate') }}</label>
											<div>
												@for ($i = config('app.one-star'); $i <= config('app.max-rating'); $i++)
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="rate" id="inlineRadio1" value={{ $i }}>
													<label class="form-check-label" for="inlineRadio1">
														@for ($a = config('app.one-star'); $a <= $i; $a++)
															<span>&#11088;</span>
														@endfor	
													</label>
												</div>
												@endfor
											</div>
											<textarea class="form-control" placeholder="{{ __('messages.leave-a-review') }}" name="content" rows="3">
											</textarea>
											<input type="hidden" name="book_id" value={{ $book->id }}>
											<button type="submit" class="btn btn-primary mt-2 float-right">{{ __('messages.edit') }}</button>
											<button class="btn btn-danger float-right mt-2 mr-2" type="button" data-toggle="collapse" data-target="#editReview{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
												{{ __('messages.cancel') }}
											</button>
										</div>
									</form>
									</div>  
							</div>
							<div class="comment-replies p-3 rounded">
								<h6 class="comment-replies-title mb-4 text-muted text-uppercase">
									{{ count($review->comments) }} {{ __('messages.comment') }}
								</h6>
								@foreach ($review->comments as $comment)
									@if ($comment->display == config('app.display'))
										<div class="reply d-flex mb-2">
										<div class="flex-shrink-0">
											<div class="avatar avatar-sm rounded-circle">
											<img id="user-img" class="avatar-img" src="{{ asset('uploads/users/' . $comment->user->image->path) }}" alt="">
											</div>
										</div>
										<div class="flex-grow-1 ms-2 ms-sm-3">
											<div class="reply-meta d-flex align-items-baseline">
											<h6 class="mb-0 me-2 ml-2 mr-2">
												<a href="{{ route('users.show', $review->user) }}">
												{{ $comment->user->username }}
												</a>          
											</h6>
											<span class="text-muted">{{ formatOutputDate($comment->updated_at) }}</span>
											</div>
											<div class="reply-body ml-2 mr-2">
											{{ $comment->content }}
											<p>
												<a class="mr-2" data-toggle="collapse" href="#editComment{{ $comment->id }}" aria-expanded="false" aria-controls="collapseExample">
													{{ __('messages.edit') }}
												</a>
												<a class="mr-2" data-toggle="collapse" href="#deleteComment{{ $comment->id }}" aria-expanded="false" aria-controls="collapseExample">
													{{ __('messages.delete') }}
												</a>
											</p>
											<div class="collapse" id="deleteComment{{ $comment->id }}">
												<form action="{{ route('comments.destroy', $comment) }}" method="post"
													class="delete-form" data-message="{{ __('messages.delete_confirm') }}">
													@csrf
													@method('DELETE')
													<h3>{{ __('messages.delete_confirm') }}</h3>
													<button type="submit" class="btn btn-warning float-left mr-2 mb-2 ">
														{{ __('messages.delete') }}
													</button>
													<button class="btn btn-danger float-left mr-2 mb-2" type="button" data-toggle="collapse" data-target="#deleteComment{{ $comment->id }}" aria-expanded="false" aria-controls="collapseExample">
														{{ __('messages.cancel') }}
													</button>
												</form>
											</div>
											<div class="collapse" id="editComment{{ $comment->id }}">
												<form method="POST" action="{{ route('comments.update', $comment) }}">
												@csrf
												@method('PUT')
												<textarea class="form-control" placeholder="{{ __('messages.leave-a-comment') }}" name="content" rows="3">
												</textarea>
												<input type="hidden" name="review_id" value={{ $review->id }}>
												<button type="submit" class="btn btn-primary mt-2 float-right">{{ __('messages.comment') }}</button>
												<button class="btn btn-danger float-right mt-2 mr-2" type="button" data-toggle="collapse" data-target="#collapseExample{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
													{{ __('messages.cancel') }}
												</button>
												</form>
											</div>
											</div>
										</div>
										</div>
									@endif
								@endforeach  
							</div>
						</div>
						@endif
					</div>
					@endforeach
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/like_and_favorite.js') }}"></script>
@endsection
