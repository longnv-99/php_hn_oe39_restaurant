<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.book-reviewing-system') }}</title>

    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/plugins/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/adminLTE/dist/css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manage_review_comment.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- header -->
        @include('admin.layouts.header')

        <!-- sidebar -->
        @include('admin.layouts.sidebar')

        <!-- main-content -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash-message')
                                    @yield('main')
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
    <script src="{{ asset('js/home.js') }}" type="text/javascript"></script>
    @yield('js')

</body>

</html>
