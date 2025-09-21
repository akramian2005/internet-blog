@extends('layouts.app')

@section('title', 'Создать категорию')

@section('content')
<h2>Создать категорию</h2>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Название категории</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Сохранить</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection
