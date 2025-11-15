    @extends('layouts.app')

    @section('content')
    <div class="container">

            <!-- Кнопка назад -->
        <a href="{{ auth()->user()->is_admin ? route('admin.tickets') : route('chat.userTickets') }}" 
        class="btn btn-secondary mb-3">← Назад</a>
        
        <h2>Тикет №{{ $ticket->id }} — {{ $ticket->user->name }}</h2>

        <div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:scroll;">
            @foreach($messages as $m)
                <p><b>{{ $m->sender->name }}:</b> {{ $m->message }}</p>
            @endforeach
        </div>

        @if($ticket->status === 'open')
        <form action="{{ route('chat.send', $ticket->id) }}" method="POST">
            @csrf
            <textarea name="message" required class="form-control"></textarea>
            <button class="btn btn-primary mt-2">Ответить</button>
        </form>


        <form action="{{ route('admin.ticket.close', $ticket->id) }}" method="POST">
            @csrf
            <button class="btn btn-danger mt-2">Закрыть заявку</button>
        </form>
        @else
        <p>Тикет закрыт.</p>
        @endif
    </div>
    @endsection
