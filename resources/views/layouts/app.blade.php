<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой блог')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/css/main.css')

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
