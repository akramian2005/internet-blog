@extends('layouts.app')

@section('title', 'Все категории')

@section('content')
<h2>Все категории</h2>

<a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Создать категорию</a>

<ul class="list-group">
    @foreach($categories as $category)
        <li class="list-group-item">
            {{-- Ссылка на show категорию --}}
            <a href="{{ route('categories.show', $category->id) }}">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
</ul>
@endsection
