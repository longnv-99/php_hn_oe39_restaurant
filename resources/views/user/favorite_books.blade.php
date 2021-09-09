@extends('user.layouts.layout')

@section('title', __('messages.list-book'))
@section('main')
<h2>{{ __('messages.favorite-books') }}</h2>
<hr>
<div class="row" id="all-book">
@foreach ($books as $book)
    <div class="col-book col-12 col-md-3">
        <div class="card-book card-info border-secondary">
            <div class="card-book-body card-body">
                <a href="{{ route('books.detail', $book) }}">
                    <img class="card-img-top" src="{{ asset('uploads/books/' . $book->image->path) }}" alt="">
                </a>
                <h5 class="book-title">
                    <div>{{ $book->title }}</div>
                    @if (Auth::check())
                        @if ($book->total_review)
                            <div class="badge">{{ round($book->total_rate/$book->total_review, config('app.two-decimal')) }}&#11088;</div>
                        @else
                            <div class="badge">0&#11088;</div>
                        @endif
                    @endif
                </h5>
                <br>
                <div class="book-action">
                    @if (in_array($book->id, $likes))
                        <button class="btn btn-primary btn-unlike" id="{{ $book->id }}">
                            <i class="fas fa-thumbs-up"></i>
                            <span id="total-like-{{ $book->id }}">{{ $book->total_like }}</span>
                        </button>
                    @else 
                        <button class="btn btn-outline-primary btn-like" id="{{ $book->id }}">
                            <i class="fas fa-thumbs-up"></i>
                            <span id="total-like-{{ $book->id }}">{{ $book->total_like }}</span>
                        </button>
                    @endif
                    <button class="btn btn-danger btn-unmark-favorite" id="{{ $book->id }}">
                        <i class="fas fa-heart"></i>
                        <span>{{ __('messages.favorite') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
@section('js')

<script src="{{ asset('js/like_and_favorite.js') }}"></script>

@endsection
