@extends('layouts.app')

@section('title', 'Редактировать категорию')

@section('content')
<h2>Редактировать категорию</h2>

<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Название категории</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection
