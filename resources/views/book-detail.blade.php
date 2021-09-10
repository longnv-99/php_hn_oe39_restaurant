@extends('layouts.app')

@section('content')
<div class="container-xl">
    <div class="row">
      	<div class="col-sm">
            <img src="{{ asset('uploads/books/' . $book->image->path) }}" class="img-thumbnail">
      	</div>
      	<div class="col-sm">
			<h1 class="my-3">{{ $book->title }}</h1>
			<p>{{ __('messages.category') }} : {{ $book->category->name }}</p>
			<p>{{ __('messages.author') }} : {{ $book->author }}</p>
			<p>{{ __('messages.publish-date') }} : {{ formatOutputDate($book->published_date) }}</p>
			<p>{{ __('messages.number-of-page') }} : {{ $book->number_of_page }}</p>
			<hr>
			<h3>{{ $avarageRating }} / {{ config('app.max-rating')}} <span>&#11088;</span></h3>
			<hr>
			<div class="mt-4">
				<a href="#" class="btn btn-primary btn-lg" role="button">{{ count($book->likes) }} &#x1F44D;</a>
				<a href="#" class="btn btn-danger btn-lg" role="button">&hearts; {{ __('messages.add-to-favorite') }}</a>
        	</div>
      	</div>
    </div>
    <hr>
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
    <h3>{{ __('messages.review-list') }}</h3>
    <form method="POST" action="{{ route('reviews.store') }}">
        @csrf
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
            <textarea class="form-control" placeholder="{{ __('messages.leave-a-review') }}" name="content" rows="4">
            </textarea>
            <input type="hidden" name="book_id" value={{ $book->id }}>
            <input type="hidden" name="user_id" value={{ Auth::check() ? getAuthUserId() : NULL }}>
        	<button type="submit" class="btn btn-primary mt-2 float-right">{{ __('messages.review') }}</button>
        </div>
    </form>
    <div class="d-flex align-items-center justify-content-center mt-5">
		<div class="container">
			<div class="row justify-content-center ">
				<div class="col-lg-12 mb-2">
					<h2>{{ count($reviews) }} {{ __('messages.review') }}</h2>
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
										{{ count($review->likes) }} &#x1F44D;
										</a>
										<a class="mr-2" data-toggle="collapse" href="#collapseExample{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
											{{ __('messages.comment') }}
										</a>
										@if ( Auth::check() && $review->user->id == getAuthUserId())
										<a class="mr-2" data-toggle="collapse" href="#editReview{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
											{{ __('messages.edit') }}
										</a>
										<form action="{{ route('reviews.destroy', $review->id) }}" method="post"
											class="delete-form" data-message="{{ __('messages.delete_confirm') }}">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger rounded-1">
												{{ __('messages.delete') }}
											</button>
										</form>
										@endif
									</p>
									<div class="collapse" id="collapseExample{{ $review->id }}">
									<form method="POST" action="{{ route('comments.store') }}">
										@csrf
										<textarea class="form-control" placeholder="{{ __('messages.leave-a-comment') }}" name="content" rows="3">
										</textarea>
										<input type="hidden" name="review_id" value={{ $review->id }}>
										<input type="hidden" name="user_id" value={{ Auth::check() ? getAuthUserId() : NULL }}>
										<button type="submit" class="btn btn-primary mt-2 float-right">{{ __('messages.comment') }}</button>
										<button class="btn btn-danger float-right mt-2 mr-2" type="button" data-toggle="collapse" data-target="#collapseExample{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
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
											<input type="hidden" name="user_id" value={{ Auth::check() ? getAuthUserId() : NULL }}>
											<button type="submit" class="btn btn-primary mt-2 float-right">{{ __('messages.edit') }}</button>
											<button class="btn btn-danger float-right mt-2 mr-2" type="button" data-toggle="collapse" data-target="#editReview{{ $review->id }}" aria-expanded="false" aria-controls="collapseExample">
												{{ __('messages.cancel') }}
											</button>
										</div>
									</form>
									</div>  
							</div>
							<div class="comment-replies bg-light p-3 rounded">
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
												@if ( Auth::check() && $comment->user->id == getAuthUserId())
												<a class="mr-2" data-toggle="collapse" href="#editComment{{ $comment->id }}" aria-expanded="false" aria-controls="collapseExample">
													{{ __('messages.edit') }}
												</a>
												<form action="{{ route('comments.destroy', $comment) }}" method="post"
													class="delete-form" data-message="{{ __('messages.delete_confirm') }}">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-danger rounded-1">
														{{ __('messages.delete') }}
													</button>
												</form>
												@endif
											</p>
											<div class="collapse" id="editComment{{ $comment->id }}">
												<form method="POST" action="{{ route('comments.update', $comment) }}">
												@csrf
												@method('PUT')
												<textarea class="form-control" placeholder="{{ __('messages.leave-a-comment') }}" name="content" rows="3">
												</textarea>
												<input type="hidden" name="review_id" value={{ $review->id }}>
												<input type="hidden" name="user_id" value={{ Auth::check() ? getAuthUserId() : NULL }}>
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
