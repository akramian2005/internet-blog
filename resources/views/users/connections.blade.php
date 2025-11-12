@extends('layouts.app')

@section('title', 'Подписки и подписчики — ' . $user->name)

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Подписки и подписчики {{ $user->name }}</h2>
    <a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary mb-3">Назад</a>

    {{-- Навигация --}}
    <ul class="nav nav-tabs mb-3" id="connectionsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab">
                Подписчики ({{ $followers->total() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="following-tab" data-bs-toggle="tab" data-bs-target="#following" type="button" role="tab">
                Подписки ({{ $following->total() }})
            </button>
        </li>
    </ul>

    {{-- Содержимое вкладок --}}
    <div class="tab-content" id="connectionsTabsContent">
        {{-- Подписчики --}}
        <div class="tab-pane fade show active" id="followers" role="tabpanel" aria-labelledby="followers-tab">
            @if($followers->count() > 0)
                <div class="list-group mb-3">
                    @foreach($followers as $follower)
                        <a href="{{ route('users.show', $follower->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <img src="{{ $follower->avatar ? asset('storage/'.$follower->avatar) : 'https://via.placeholder.com/50' }}" 
                                 alt="{{ $follower->name }}" class="rounded-circle me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <strong>{{ $follower->name }}</strong><br>
                                <small class="text-muted">{{ $follower->email }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
                {{ $followers->links() }}
            @else
                <p class="text-muted">Нет подписчиков.</p>
            @endif
        </div>

        {{-- Подписки --}}
        <div class="tab-pane fade" id="following" role="tabpanel" aria-labelledby="following-tab">
            @if($following->count() > 0)
                <div class="list-group mb-3">
                    @foreach($following as $followed)
                        <a href="{{ route('users.show', $followed->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <img src="{{ $followed->avatar ? asset('storage/'.$followed->avatar) : 'https://via.placeholder.com/50' }}" 
                                 alt="{{ $followed->name }}" class="rounded-circle me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <strong>{{ $followed->name }}</strong><br>
                                <small class="text-muted">{{ $followed->email }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
                {{ $following->links() }}
            @else
                <p class="text-muted">Пользователь ни на кого не подписан.</p>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary">Назад в профиль</a>
    </div>
</div>
@endsection
