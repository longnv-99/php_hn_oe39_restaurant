<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.book-reviewing-system') }}</title>

    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/plugins/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/dist/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/dist/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        @include('user.layouts.header')

        <div class="ht__bradcaump__area bg-image--6">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bradcaump__inner text-center">
                            <h2 class="bradcaump-title">{{ __('messages.book-reviewing-system') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-shop-sidebar left--sidebar bg--white section-padding--lg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-12 order-2 order-lg-1 md-mt-40 sm-mt-40">
                        <div class="shop__sidebar">
        	                @include('user.layouts.sidebar')
                        </div>
                    </div>
                    <div class="col-lg-10 col-12 order-1 order-lg-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="shop__list__wrapper d-flex flex-wrap flex-md-nowrap justify-content-between">
                                    <div class="shop__list nav justify-content-center" role="tablist">
                                        <a class="nav-item nav-link active" data-toggle="tab" href="#nav-grid" role="tab"><i class="fa fa-th"></i></a>
                                    </div>
                                    @yield('title')
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
                                </div>
                            </div>
                        </div>
                        <div class="tab__container">
                            <div class="shop-grid tab-pane fade show active" id="nav-grid" role="tabpanel">
                                <div class="row" id="all-book">
                                    @yield('main')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('bower_components/adminLTE/plugins/jquery/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('bower_components/adminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/adminLTE/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/adminLTE/dist/js/pusher.min.js') }}"></script>
    <script src="{{ asset('bower_components/adminLTE/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/home.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/like_and_favorite.js') }}"></script>
    @translations
    <script src="{{ asset('js/realtime-follow-notify.js') }}"></script>
</body>

</html>
