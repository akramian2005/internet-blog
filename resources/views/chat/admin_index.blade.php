@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Чаты с пользователями</h2>

    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item">
                <a href="{{ route('admin.chat', $user->id) }}">
                    {{ $user->name }} ({{ $user->email }})
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
