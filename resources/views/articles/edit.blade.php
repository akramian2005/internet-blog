@extends('layouts.app')

@section('title', 'Редактировать статью')

@section('content')
    <h2>Редактировать статью</h2>

    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Заголовок</label>
            <input type="text" name="title" class="form-control" 
                   value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Категория</label>
            <select name="category_id" class="form-control">
                <option value="">Выберите категорию</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Текст</label>
            <textarea name="content" class="form-control" rows="6" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Текущая картинка</label><br>
            @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" 
                     class="img-fluid mb-2" style="max-width: 300px;">
            @else
                <p>Картинка не загружена</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Заменить картинку</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-secondary">Отмена</a>
    </form>
@endsection
