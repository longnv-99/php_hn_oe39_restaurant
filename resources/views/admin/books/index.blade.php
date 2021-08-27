@extends('admin.layouts.layout')

@section('title', __('messages.list-book'))
@section('main')
<div class="content-header">
    <a href="{{ route('books.create') }}" class="btn btn-outline-primary">{{ __('messages.add-book') }}</a>
    <form class="form-inline">
        <div class="form-group">
            <input type="text" name="title" class="form-control" placeholder="{{ __('messages.enter-title') }}">
        </div>
        <button type="submit" class="btn btn-primary" id="btn-search">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>
<hr>
@if ($books->isEmpty())
    <h2>{{ __('messages.no-book') }}</h2>
@else
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">{{ __('messages.stt') }}</th>
                <th class="text-center">{{ __('messages.title') }}</th>
                <th class="text-center">{{ __('messages.category') }}</th>
                <th class="text-center">{{ __('messages.author') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td scope="row">{{ $loop->index + 1 }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->author }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
@endsection
