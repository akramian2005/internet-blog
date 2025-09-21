<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой блог')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/main.css')
    <style>
        /* Основной flex-контейнер */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* занимает весь экран */
        }
        main {
            flex: 1; /* основной контент растягивается */
        }
    </style>
</head>
<body>
    {{-- Хедер --}}
    @include('layouts.header')

    <main class="container my-4">
        @yield('content')
    </main>

    {{-- Футер --}}
    @include('layouts.footer')
</body>
</html>
