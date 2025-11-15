@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Мои заявки</h2>

    <form action="{{ route('chat.createTicket') }}" method="POST" class="d-inline mb-3">
        @csrf
        <button type="submit" class="btn btn-success">Создать заявку</button>
    </form>

    @if($tickets->isEmpty())
        <p>У вас пока нет тикетов.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('chat.chat', $ticket->id) }}" class="btn btn-primary btn-sm">Открыть чат</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
