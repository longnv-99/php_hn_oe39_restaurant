@extends('user.layouts.layout')

@section('title', __('messages.list-book'))
@section('main')
<form class="form-inline" action="{{ route('books.search-title') }}">
    <div class="form-group">
        @if (isset($title))
            <input type="text" name="title" value="{{ $title }}" id="" class="form-control" placeholder="{{ __('messages.enter-title') }}">
        @else
            <input type="text" name="title" id="" class="form-control" placeholder="{{ __('messages.enter-title') }}">
        @endif
    </div>
    <button type="submit" class="btn btn-primary" id="btn-search">
        <i class="fas fa-search"></i>
    </button>
</form>
<hr>
<div class="row">
@foreach ($books as $book)
    <div class="col-book col-12 col-md-3">
        <div class="card-book card-info border-secondary">
            <div class="card-book-body card-body">
                <a href="{{ route('books.detail', $book) }}">
                    <img class="card-img-top" src="{{ asset('uploads/books/' . $book->image->path) }}" alt="">
                </a>
                <h5 class="book-title">{{ $book->title }}</h5>
                <br>
                <div class="book-action">
                    <a href="" class="btn btn-outline-primary">
                        <i class="fas fa-thumbs-up"></i>
                        <span>{{ $book->total_like }}</span>
                    </a>
                    <a href="" class="btn btn-outline-success">
                        <i class="fas fa-bookmark"></i>
                        <span>{{ __('messages.add-to-favorite') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
