@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Контакты</h1>
    <p>Свяжитесь с нами по email: <a href="mailto:info@example.com">info@example.com</a></p>
    <p>Телефон: <a href="tel:+1234567890">+996 (234) 567-890</a></p>
    <p>Адрес: ул. Фрунзе, 123, Бишкек, Кыргызстан</p>

    <h3>Форма обратной связи</h3>
    <form action="{{ route('support.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Ваше имя</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Ваш email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Сообщение</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

</div>
@endsection
