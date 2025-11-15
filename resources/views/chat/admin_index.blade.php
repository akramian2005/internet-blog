@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Все заявки</h2>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Статус</th>
            <th></th>
        </tr>

        @foreach($tickets as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->user->name }}</td>
            <td>{{ $t->status }}</td>
            <td>
                <a href="{{ route('admin.ticket.chat', $t->id) }}" class="btn btn-primary">Открыть</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
