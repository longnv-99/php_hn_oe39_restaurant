<aside class="wedget__categories poroduct--cat">
    <h3 class="wedget__title">{{ __('messages.category') }}</h3>
    <ul>
        @foreach ($categoryChildren as $cateChild)
            <li><a href="{{ route('books.search-category', $cateChild) }}">{{ $cateChild->name }} <span>({{ count($cateChild->books) }})</span></a></li>
        @endforeach
    </ul>
</aside>
