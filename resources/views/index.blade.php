@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <h2>Главная страница</h2>

    @auth
    <a href="{{ route('articles.create') }}" class="btn btn-success mb-3">Добавить статью</a>
   
    @endauth

    {{-- Включаем блок всех статей --}}
    @include('articles._all_articles', ['articles' => $articles])
@endsection