@extends('layouts.app')

@section('title', $article->title)

@section('content')
<a href="{{ route('index') }}" class="btn btn-secondary mt-3">Назад к списку</a>
    <div class="card mb-3">
        
        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}">
        @endif
        <div class="card-body">
            <h2>{{ $article->title }}</h2>
            <p class="text-muted">Автор: {{ $article->user->name }}</p>
            <p>{{ $article->content }}</p>
        </div>
    </div>

    {{-- Кнопка редактирования и удаления (только для автора) --}}
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
