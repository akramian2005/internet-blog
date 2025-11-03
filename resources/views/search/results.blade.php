@extends('layouts.app')

@section('title', 'Результаты поиска')

@section('content')
<div class="container mt-4">
    <h2>Результаты поиска по запросу: "{{ $query }}"</h2>

    {{-- Найденные статьи --}}
    <h4 class="mt-4 mb-3">Статьи</h4>
    @if($articles->count() > 0)
        <div class="list-group mb-4">
            @foreach($articles as $article)
                <a href="{{ route('articles.show', $article->id) }}" class="list-group-item list-group-item-action">
                    <strong>{{ $article->title }}</strong><br>
                    <small>Автор: {{ $article->user->name }} | Категория: {{ $article->category->name ?? '—' }}</small>
                </a>
            @endforeach
        </div>
        {{ $articles->appends(['q' => $query])->links() }}
    @else
        <p class="text-muted">Статьи не найдены.</p>
    @endif

    {{-- Найденные пользователи --}}
    <h4 class="mt-5 mb-3">Пользователи</h4>
    @if($users->count() > 0)
        <div class="list-group">
            @foreach($users as $user)
                <a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://via.placeholder.com/40' }}" 
                         alt="{{ $user->name }}" 
                         class="rounded-circle me-3" 
                         style="width: 40px; height: 40px; object-fit: cover;">
                    <div>
                        <strong>{{ $user->name }}</strong><br>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                </a>
            @endforeach
        </div>
        {{ $users->appends(['q' => $query])->links() }}
    @else
        <p class="text-muted">Пользователи не найдены.</p>
    @endif
</div>
@endsection
