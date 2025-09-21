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

@endsection
