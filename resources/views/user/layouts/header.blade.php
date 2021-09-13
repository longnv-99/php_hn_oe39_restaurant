<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home.index') }}" role="button"><i class="fas fa-home"> {{ __('messages.dashboard') }}</i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="{{ route('change-language', ['en']) }}" class="dropdown-item lang-item">
                <i class="flag-icon flag-icon-gb-eng mr-2"></i>{{ __('messages.english') }}
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('change-language', ['vi']) }}" class="dropdown-item lang-item">
                <i class="flag-icon flag-icon-vn mr-2"></i>{{ __('messages.vietnamese') }}
            </a>
        </li>
        @if (Auth::check())
            <li class="nav-item">
                <p id="navbarDropdown" class="nav-item dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <img src="{{ asset('uploads/users/' . Auth::user()->image->path) }}" id="user-img" class="img-circle elevation-2" alt="User Image">
                    {{ Auth::user()->username }}
                </p>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">
                        {{ __('messages.my-profile') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('favorites.index') }}">
                        {{ __('messages.favorite-books') }}
                    </a>
                    <a class="dropdown-item" href="#" id="logout-btn">
                        {{ __('messages.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>    
        @else
            <li class="nav-item">
                <a class="dropdown-item" href="{{ route('login') }}">
                    {{ __('messages.login') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="dropdown-item" href="{{ route('register') }}">
                    {{ __('messages.register') }}
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
