@extends('layouts.app')

@section('title', $category->name)

@section('content')
<h2>Категория: {{ $category->name }}</h2>

<a href="{{ route('index') }}" class="btn btn-secondary mb-3">Назад на главную</a>
<a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">Все категории</a>

@auth
    @if(auth()->user()->is_admin)
        <div class="mb-3">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Редактировать категорию</a>
        </div>
    @endif
@endauth



<h3>Статьи этой категории</h3>

@include('articles._card_articles', ['articles' => $articles, 'imgHeight' => 300])

@endsection
