@extends('layouts.app')

@section('title', $user->name . ' — Профиль')

@section('content')
<div class="d-flex align-items-center mb-4 position-relative">
    <a href="{{ route('index') }}" class="btn btn-secondary mb-3">Назад</a>
    <h2 class="m-0 w-100 text-center">Профиль</h2>
</div>

<div class="row">
    {{-- Левая колонка: аватар и информация --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                         alt="{{ $user->name }}" 
                         class="rounded-circle mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/150" 
                         alt="Аватар отсутствует" 
                         class="rounded-circle mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                @endif

                <h4>{{ $user->name }}</h4>

                @if($user->about)
                    <p class="mt-2">{{ $user->about }}</p>
                @elseif(!auth()->check() || auth()->id() !== $user->id)
                    <p class="text-muted"><em>Пользователь не заполнил информацию о себе.</em></p>
                @endif

                                {{-- Блок подписки --}}
                @if(auth()->check() && auth()->id() !== $user->id)
                    <form action="{{ route('users.follow', $user) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                            {{ auth()->user()->isFollowing($user) ? 'Отписаться' : 'Подписаться' }}
                        </button>
                    </form>
                @endif

                <p class="mt-2">
                    <strong>Подписчики:</strong> {{ $user->followers()->count() }} <br>
                    <strong>Подписки:</strong> {{ $user->following()->count() }}
                </p>
            </div>
                {{-- Кнопка Безопасность --}}
            @if(auth()->check() && auth()->id() === $user->id)
                <a href="{{ route('profile.security') }}" class="btn btn-warning w-100 mt-3">
                    Безопасность
                </a>
            @endif
        </div>
    </div>

    {{-- Правая колонка: редактирование и статьи --}}
    <div class="col-md-8">
        @if(auth()->check() && auth()->id() === $user->id)
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Редактирование профиля</h5>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="about" class="form-label">О себе</label>
                            <textarea name="about" id="about" class="form-control" rows="4">{{ old('about', $user->about) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">Аватар</label>
                            <input type="file" name="avatar" id="avatar" class="form-control form-control-sm">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Сохранить изменения</button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Список статей --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Статьи пользователя</h5>
                @if($user->articles->count())
                    <ul class="list-unstyled">
                        @foreach($user->articles as $article)
                            <li class="mb-2">
                                <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                                <small class="text-muted">({{ $article->created_at->format('d.m.Y') }})</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted"><em>Пользователь еще не написал ни одной статьи.</em></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
