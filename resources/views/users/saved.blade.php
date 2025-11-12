@extends('layouts.app')

@section('title', 'Сохранённые статьи — ' . $user->name)

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary mb-3">Назад</a>
    <h2 class="m-0 w-100 text-center">Сохранённые статьи</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($articles->count())
            <ul class="list-unstyled">
                @foreach($articles as $article)
                    <li class="mb-2">
                        <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                        <small class="text-muted">({{ $article->created_at->format('d.m.Y') }})</small>
                        <span class="text-muted">— автор: {{ $article->user->name }}</span>
                        @if($article->category)
                            <span class="text-muted">| категория: {{ $article->category->name }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted"><em>Вы ещё не сохранили ни одной статьи.</em></p>
        @endif
    </div>
</div>
@endsection
