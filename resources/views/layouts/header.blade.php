<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Медблог</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">

        {{-- Поиск --}}
        <li class="nav-item me-2">
          <form action="{{ route('search') }}" method="GET" class="d-flex align-items-center">
            <input class="form-control form-control-sm me-1" 
                  type="search" 
                  name="q" 
                  placeholder="Поиск..." 
                  value="{{ request('q') }}" 
                  aria-label="Поиск">
            <button class="btn btn-outline-light btn-sm" type="submit">🔍</button>
          </form>
        </li>

        {{-- Категории --}}
        <li class="nav-item dropdown">
          <a class="nav-link btn btn-success text-white ms-2" 
             href="{{ auth()->check() && auth()->user()->is_admin ? route('categories.index') : '#' }}" 
             id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Категории
          </a>
          <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
              @foreach(\App\Models\Category::all() as $category)
                  <li>
                      <a class="dropdown-item" href="{{ route('categories.show', $category->id) }}">
                          {{ $category->name }}
                      </a>
                  </li>
              @endforeach
          </ul>
        </li>

        {{-- Авторизованный пользователь --}}
        @auth
          <li class="nav-item ms-2">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-danger btn-sm">Выйти</button>
            </form>
          </li>
          <li class="nav-item ms-2">
            <a class="nav-link btn btn-info btn-sm text-white" 
               href="{{ route('users.show', auth()->user()->id) }}">
                  Профиль
            </a>
          </li>
        @endauth

        {{-- Гость --}}
        @guest
          <li class="nav-item ms-2">
            <a href="{{ route('login.show') }}" class="btn btn-primary btn-sm">Войти</a>
            <a href="{{ route('register.show') }}" class="btn btn-secondary btn-sm ms-1">Регистрация</a>
          </li>
        @endguest

        {{-- О нас и Контакты --}}
        <li class="nav-item ms-2">
          <a class="nav-link" href="{{ route('about') }}">О нас</a>
        </li>
        <li class="nav-item ms-2">
          <a class="nav-link" href="{{ route('contacts') }}">Контакты</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
