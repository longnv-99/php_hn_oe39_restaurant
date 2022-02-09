@extends('admin.layouts.layout')

@section('title', __('messages.add-book'))
@section('main')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.new-book') }}</h3>
                    </div>
                    <form id="form-add" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">{{ __('messages.select-cate') }}</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputName">{{ __('messages.title') }}</label>
                                <input type="text" name="title" class="form-control" id="inputName" placeholder="{{ __('messages.enter-title') }}" aria-invalid="false">
                                @error('title')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAuthor">{{ __('messages.author') }}</label>
                                <input type="text" name="author" class="form-control" id="inputAuthor" placeholder="{{ __('messages.enter-author') }}" aria-invalid="false">
                                @error('author')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="numberOfPage">{{ __('messages.number-of-page') }}</label>
                                <input type="number" name="number_of_page" class="form-control" id="numberOfPage" placeholder="{{ __('messages.enter-numberPage') }}" aria-invalid="false">
                                @error('number_of_page')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="publishDate">{{ __('messages.publish-date') }}</label>
                                <input type="date" name="published_date" class="form-control" id="publishDate" aria-invalid="false">
                                @error('published_date')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image-input">{{ __('messages.image') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image-input" name="image" accept="image/*">
                                        <label class="custom-file-label" for="image-input">{{ __('messages.choose-file') }}</label>
                                    </div>
                                </div>
                                @error('image')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
