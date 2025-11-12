@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Чат поддержки</h2>

    <div style="max-height: 400px; overflow-y: scroll; border:1px solid #ccc; padding:10px;">
        @foreach($messages as $msg)
            <div style="margin-bottom:10px; {{ $msg->user_id == Auth::id() ? 'text-align:right;' : '' }}">
                <strong>{{ $msg->user->name }}:</strong> {{ $msg->message }}
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('chat.send') }}" class="mt-3">
        @csrf
        <textarea name="message" rows="3" class="form-control" placeholder="Введите сообщение..."></textarea>
        <button type="submit" class="btn btn-primary mt-2">Отправить</button>
    </form>
</div>
@endsection
