@component('mail::message')

# @lang('messages.hello') {{ $user->username }},
@lang('messages.announce-list-reviews')

@component('mail::table')

|                                            |                                         |                                            |
|--------------------------------------------|:----------------------------------------|:------------------------------------------:|
@foreach ($favoriteBooks as $book)
| <b>{{ $book->title }}</b>                  |                                         |                                            |
| <b>@lang('messages.user')</b>              | <b>@lang('messages.content-review')</b> | <b>@lang('messages.rate')</b>              |
@foreach ($book->reviews as $review)
@if ($review->updated_at >= now()->subDays(7))
| <span>{{ $review->user->username }}</span> | <span>{{ $review->content }}</span>     | <span>{{ $review->rate }} &#11088; </span> |
@endif
@endforeach
@endforeach

@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
