<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <div class="brand-text font-weight-light text-center">{{ __('messages.user') }}</div>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('users.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-home }}"></i>
                        <p>{{ __('messages.dashboard') }}</p>
                    </a>
                </li>
                @foreach ($categoryParents as $cateParent)
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="right fas fa-angle-right"></i>
                            <p>{{ $cateParent->name }}</p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach ($categoryChildren as $cateChild)
                                @if ($cateChild->parent_id == $cateParent->id)
                                    <li class="nav-item">
                                        <a href="" class="nav-link cate-child" id="{{ $cateChild->id }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ $cateChild->name }}</p>
                                        </a>
                                    </li>
                                @endif    
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
