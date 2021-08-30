@extends('admin.layouts.layout')

@section('title', __('messages.list-user'))
@section('main')
<form class="form-inline">
    <div class="form-group">
        <input type="text" name="key" id="" class="form-control" placeholder="{{ __('messages.enter-user') }}">
    </div>
    <button type="submit" class="btn btn-primary" id="btn-search">
        <i class="fas fa-search"></i>
    </button>
</form>
<hr>
<table class="table table-hover table-bordered">
    <thead class="thead-dark">
        <tr>
            <th class="text-center">{{ __('messages.stt') }}</th>
            <th class="text-center">{{ __('messages.username') }}</th>
            <th class="text-center">{{ __('messages.email') }}</th>
            <th class="text-center">{{ __('messages.fullname') }}</th>
            <th class="text-center">{{ __('messages.dob') }}</th>
            <th class="text-center">{{ __('messages.active') }}</th>
            <th class="text-center">{{ __('messages.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
            <tr>
                <td scope="row">{{ $users->firstItem() + $key }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->fullname }}</td>
                <td>{{ $user->dob }}</td>
                <td class="is_active">{{ $user->is_active }}</td>
                <td class="text-center">
                    <a href="{{ route('users.enable', $user) }}" class="btn btn-sm btn-success btn-enable">
                        {{ __('messages.enable') }}
                    </a>
                    <a href="{{ route('users.disable', $user) }}" class="btn btn-sm btn-secondary btn-disable">
                        {{ __('messages.disable') }}
                    </a>
                    <a href="{{ route('users.destroy', $user) }}" class="btn btn-sm btn-danger btn-delete">
                        {{ __('messages.delete') }}
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<br>
<div>
    {{ $users->links() }}
</div>
<form method="POST" id="form-delete">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('js')

<script src="{{ asset('js/manage_user.js') }}"></script>

@endsection
