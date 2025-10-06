@extends('layouts.app')

@section('title', $article->title)

@section('content')
<a href="{{ route('index') }}" class="btn btn-secondary mt-3">Назад к списку</a>

<div class="card mb-3">
    @if($article->image)
        <div style="width: 100%; max-width: 1300px; height: 500px; overflow: hidden; margin: 0 auto;">
            <img src="{{ asset('storage/' . $article->image) }}" 
                 alt="{{ $article->title }}"
                 style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
        </div>
    @endif
    <div class="card-body">
        <h2>{{ $article->title }}</h2>
        <p class="text-muted">
            Автор: {{ $article->user->name }} |
            Категория: <strong>{{ optional($article->category)->name }}</strong>
        </p>
        <p>{{ $article->content }}</p>

        <!-- Лайки -->
        <div class="mb-3">
            @auth
                <form action="{{ route('articles.like', $article->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        ❤️ Лайки ({{ $article->likes_count }})
                    </button>
                </form>
            @else
                <button type="button" class="btn btn-outline-danger" disabled>
                    ❤️ Лайки ({{ $article->likes_count }})
                </button>
                <small class="text-muted ms-2">Войдите, чтобы поставить лайк</small>
            @endauth
        </div>

    </div>
</div>

@auth
    @if(auth()->id() === $article->user_id)
        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary">Редактировать</a>

        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>
    @endif
@endauth

<!-- Комментарии -->
<div class="card mt-4">
    <div class="card-body">
        <h4>Комментарии ({{ $article->comments->count() }})</h4>

        @foreach($article->comments as $comment)
            <div class="mb-3 border-bottom pb-2">
                <strong>{{ $comment->user->name }}:</strong>
                <p>{{ $comment->content }}</p>
                <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
            </div>
        @endforeach

        <!-- Форма добавления комментария -->
        @auth
        <form action="{{ route('comments.store', $article->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" placeholder="Оставьте комментарий" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Отправить</button>
        </form>
        @else
        <p class="text-muted">Чтобы оставить комментарий, <a href="{{ route('login.show') }}">войдите в систему</a>.</p>
        @endauth
    </div>
</div>

@endsection
