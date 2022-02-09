@extends('admin.layouts.layout')

@section('title', __('messages.book-statistic'))
@section('main')
<input type="hidden" name="" id='books' value="{{ $books }}">
<div class="card card-primary">
    <div class="card-header">{{ __('messages.like-statistic') }}</div>
    <div class="card-body">
        <canvas id="like-chart"></canvas>
    </div>
</div>
<div class="card card-danger">
    <div class="card-header">{{ __('messages.review-statistic') }}</div>
    <div class="card-body">
        <canvas id="review-chart"></canvas>
    </div>
</div>
<input type="hidden" name="" id='book-comments' value="{{ $bookComments }}">
<div class="card card-success">
    <div class="card-header">{{ __('messages.comment-statistic') }}</div>
    <div class="card-body">
        <canvas id="comment-chart"></canvas>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/book_statistic.js') }}"></script>
@endsection
