<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой блог')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/main.css')
</head>
<body>
    {{-- Хедер --}}
    @include('layouts.header')

    <div class="container my-4">
        @yield('content')
    </div>

    {{-- Футер --}}
    @include('layouts.footer')
</body>
</html>
