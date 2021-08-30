@extends('admin.layouts.layout')

@section('title', __('messages.update-book'))
@section('main')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.update-book') }}</h3>
                    </div>
                    <form id="form-add" action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">{{ __('messages.select-cate') }}</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @php if ($category->id == $book->category_id) echo "selected"; @endphp>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputName">{{ __('messages.title') }}</label>
                                <input type="text" value="{{ $book->title }}" name="title" class="form-control" id="inputName" aria-invalid="false"
                                    placeholder="{{ __('messages.enter-title') }}">
                                @error('title')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAuthor">{{ __('messages.author') }}</label>
                                <input type="text" value="{{ $book->author }}" name="author" class="form-control" id="inputAuthor" aria-invalid="false"
                                    placeholder="{{ __('messages.enter-author') }}">
                                @error('author')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="numberOfPage">{{ __('messages.number-of-page') }}</label>
                                <input type="number" value="{{ $book->number_of_page }}" name="number_of_page" class="form-control" id="numberOfPage"
                                    aria-invalid="false" placeholder="{{ __('messages.enter-numberPage') }}">
                                @error('number_of_page')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="publishDate">{{ __('messages.publish-date') }}</label>
                                <input type="date" name="published_date" class="form-control" id="publishDate" aria-invalid="false"
                                    value="{{ $book->published_date }}">
                                @error('published_date')
                                    <small class="help-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image-input">{{ __('messages.image') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image-input" name="image" accept="image/*">
                                        <label class="custom-file-label" for="image-input">{{ $book->image->path }}</label>
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
