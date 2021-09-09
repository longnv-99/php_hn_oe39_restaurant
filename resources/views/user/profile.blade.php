<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.profile') }}</title>
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="content-wrapper" id="custom">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <a href="{{ route('users.home') }}">{{ __('messages.back-home') }}</a>
                        </div>
                        <div class="col-sm-3">
                            <h1>{{ __('messages.profile') }}</h1>
                        </div>
                        <div class="col-sm-3">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('users.show', Auth::user()) }}">{{ __('messages.my-profile') }}</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('uploads/users/' . $user->image->path) }}">
                                    </div>
                                    <h3 class="profile-username text-center">{{ $user->fullname }}</h3>
                                    <p class="text-muted text-center">{{ $user->username }}</p>
                                    <p class="text-muted text-center">{{ $user->dob }}</p>
                                    <p class="text-muted text-center">{{ $user->email }}</p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>{{ __('messages.follower-num') }}</b>
                                            <a class="float-right">{{ $user->number_of_followed }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{ __('messages.following') }}</b>
                                            <a class="float-right" id="followingNumber">{{ $user->number_of_follower }}</a>
                                        </li>
                                    </ul>
                                    @if (Auth::id() == $user->id)
                                        <a href="#" class="btn btn-primary btn-block"><b>{{ __('messages.edit-profile') }}</b></a>
                                    @else
                                        @if ($relationship->isEmpty())
                                            <button id="{{ $user->id }}" class="btn btn-primary btn-block follow">{{ __('messages.follow') }}</button>
                                        @else
                                            <button id="{{ $user->id }}" class="btn btn-danger btn-block unfollow">{{ __('messages.unfollow') }}</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#following" data-toggle="tab">{{ __('messages.following') }}</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#follower" data-toggle="tab">{{ __('messages.follower') }}</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="following">
                                            @foreach ($user->followers as $follower)
                                                <div class="post">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm" src="{{ asset('uploads/users/' . $follower->followed->image->path) }}" alt="#">
                                                        <span class="username">
                                                            <a href="{{ route('users.show', $follower->followed) }}">
                                                                {{ $follower->followed->fullname }}
                                                            </a>
                                                        </span>
                                                        <span class="description">{{ $follower->followed->username }}</span>
                                                    </div>
                                                    @if (Auth::id() == $user->id)
                                                        <div class="form-group row">
                                                            @if ($follower->deleted_at == null)
                                                                <button class="btn btn-secondary unfollow" id="{{ $follower->followed->id }}">
                                                                    <i class="fas fa-ban"></i>
                                                                    {{ __('messages.unfollow') }}
                                                                </button>
                                                            @else
                                                                <button class="btn btn-info follow" id="{{ $follower->followed->id }}">
                                                                    <i class="fas fa-user-plus"></i>
                                                                    {{ __('messages.follow') }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane" id="follower">
                                            @foreach ($user->followeds as $followed)
                                                <div class="post">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm" src="{{ asset('uploads/users/' . $followed->follower->image->path) }}" alt="#">
                                                        <span class="username">
                                                            <a href="{{ route('users.show', $followed->follower) }}">{{ $followed->follower->fullname }}</a>
                                                        </span>
                                                        <span class="description">{{ $followed->follower->username }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3>{{ __('messages.review-history') }}</h3>
                                </div>
                                <div class="card-body">
                                    @if ($reviews->isEmpty())
                                        <span>{{ __('messages.no-review') }}</span>
                                    @else
                                        <table class="table table-hover table-bordered">
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
                                                @foreach ($reviews as $key => $review)
                                                    <tr class="clickable-row" data-href="{{ route('books.detail', $review->book) }}">
                                                        <td class="text-center" scope="row">{{ $reviews->firstItem() + $key }}</td>
                                                        <td class="text-center">{{ $review->rate }}<span>&#11088;</span></td>
                                                        <td class="text-center">{{ $review->book->title }}</td>
                                                        <td>{{ $review->content }}</td>
                                                        <td class="text-center">{{ formatOutputDate($review->updated_at) }}</td>
                                                    <tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div>
                                            {{ $reviews->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="{{ asset('bower_components/adminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/adminLTE/dist/js/adminlte.min.js') }}"></script>
    @translations
    <script src="{{ asset('js/profile.js') }}"></script>
</body>

</html>
