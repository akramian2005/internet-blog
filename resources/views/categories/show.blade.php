@extends('layouts.app')

@section('title', $category->name)

@section('content')
<h2>Категория: {{ $category->name }}</h2>

<a href="{{ route('index') }}" class="btn btn-secondary mb-3">Назад на главную</a>

@auth
    @if(auth()->user()->is_admin)
        <div class="mb-3">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Редактировать категорию</a>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Все категории</a>
        </div>
    @endif
@endauth

@include('articles._card_articles', ['articles' => $category->articles, 'imgHeight' => 300])
@endsection
