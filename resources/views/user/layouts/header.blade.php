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
            <input hidden id="user_id" value="{{ Auth::id() }}" />
            <li class="nav-item">
                <p id="navbarDropdown" class="nav-item dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" v-pre>
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
            
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge notification-count">
                        {{ Auth::user()->unreadNotifications->count() }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right menu-notification">
                    @foreach (Auth::user()->notifications as $notification)
                        @if ($notification->type == 'App\Notifications\FollowNotification')
                            @php
                                $id_user = $notification->data['user']['id'];
                                $noti_id = $notification->id;
                            @endphp
                            <a class="dropdown-item @if ($notification->read_at) read-noti @endif"
                                href="{{ route('users.show', ['user'=> $id_user, 'markRead'=>$noti_id]) }}">
                                <i class="fas fa-user-friends mr-2"></i>
                                <span>
                                    {{ $notification->data['user']['username'] }}
                                    {{ __('messages.followed') }}
                                </span>
                                <span class="float-right text-muted text-sm">{{ $notification->created_at->format('d-m-y') }}</span>
                            </a>
                        @endif
                    @endforeach
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
