@extends('layouts.app')

@section('content')
<div class="container">
    <div class = "row">
        <div class="col-sm-3">
            @if ($user->id == getAuthUserId())
                <img class="img-thumbnail rounded" src="{{ asset('uploads/users/' . Auth::user()->image->path) }}" alt="">
            @else
                <img class="img-thumbnail rounded" src="{{ asset('uploads/users/' . $user->image->path) }}" alt="">
            @endif
        </div>
        <div class="col-sm">
            <h5>{{ __('messages.username') }} : {{$user->username}}</h5>
            <h5>{{ __('messages.fullname') }} : {{$user->fullname}}</h5>
            <h5>{{ __('messages.email') }} : {{$user->email}}</h5>
            <h5>{{ __('messages.dob') }} : {{$user->dob}}</h5>
            @if ($user->id != getAuthUserId())
                <a class="btn btn-primary" href="#" role="button">Follow</a>
            @endif
        </div>
    </div>
    <hr>
    <div>
        <h3 class="text-center">{{ __('messages.review-history') }}</h3>
    </div>
    @if ($reviewHistory->isEmpty())
        <h2 class="text-center">{{ __('messages.no-review') }}</h2>
    @else
    <table class="table table-hover ">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">{{ __('messages.stt') }}</th>
                <th class="text-center">{{ __('messages.rate') }}</th>
                <th class="text-center">{{ __('messages.book-name') }}</th>
                <th class="text-center">{{ __('messages.content') }}</th>
                <th class="text-center">{{ __('messages.date') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviewHistory as $review)
                <tr class="clickable-row" data-href="{{ route('books.detail', $review->book) }}">
                    <td width="5%" class="text-center" scope="row">{{ $loop->index + 1 }}</td>
                    <td width="4%" class="text-center">{{ $review->rate }}<span>&#11088;</span></td>
                    <td width="20%" class="text-center">{{ $review->book->title }}</td>
                    <td width="60%">{{ $review->content }}</td>
                    <td class="text-center">{{ formatOutputDate($review->updated_at) }}</td>
                <tr>    
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
