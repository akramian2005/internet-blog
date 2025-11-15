@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Кнопка назад -->
    <a href="{{ route('chat.userTickets') }}" class="btn btn-secondary mb-3">← Назад к списку заявок</a>
    
    <h2>Тикет №{{ $ticket->id }} — статус: {{ $ticket->status }}</h2>

    <div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:scroll;">
        @foreach($messages as $m)
            <p><b>{{ $m->sender->name }}:</b> {{ $m->message }}</p>
        @endforeach
    </div>

    @if($ticket->status === 'open')
    <form action="{{ route('chat.send', $ticket->id) }}" method="POST" class="mt-2">
        @csrf
        <textarea name="message" required class="form-control mb-2" placeholder="Введите сообщение"></textarea>
        <button class="btn btn-primary">Отправить</button>
    </form>

    <form action="{{ route('ticket.close', $ticket->id) }}" method="POST" class="mt-2">
        @csrf
        <button class="btn btn-danger">Моя проблема решена (закрыть)</button>
    </form>
    @else
    <p class="mt-2">Тикет закрыт.</p>
    @endif

</div>
@endsection
