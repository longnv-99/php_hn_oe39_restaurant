@extends('admin.layouts.layout')

@section('title', __('messages.book-detail'))
@section('main')
<section class="content">
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="col-12">
                        <img src="{{ asset('uploads/' . $book->image->path) }}" class="product-image">
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
