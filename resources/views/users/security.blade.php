@extends('layouts.app')

@section('title', $user->name . ' — Безопасность')

@section('content')
<div class="container mt-4">
    <h2>Настройки безопасности</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.updateSecurity') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Новый пароль</label>
            <input type="password" name="password" id="password" 
                   class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-warning">Сохранить изменения</button>
    </form>
</div>
@endsection
