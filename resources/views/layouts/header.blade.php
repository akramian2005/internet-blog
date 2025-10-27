<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Медблог</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        {{-- Категории — видны всем --}}
        @foreach(\App\Models\Category::all() as $category)
            <li class="nav-item">
                <a class="nav-link text-white" 
                  href="{{ route('categories.show', $category->id) }}">
                  {{ $category->name }}
                </a>
            </li>
        @endforeach


        {{-- Кнопка для админа — страницы категорий --}}
        @auth
            @if(auth()->user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link btn btn-success text-white ms-2" 
                       href="{{ route('categories.index') }}">
                        Категории
                    </a>
                </li>
            @endif
        @endauth

        {{-- Авторизованный пользователь --}}
        @auth
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-danger mb-3">Выйти</button>
            </form>
          </li>
          <li class="nav-item">
                <a class="nav-link btn btn-info text-white ms-2" 
                  href="{{ route('users.show', auth()->user()->id) }}">
                    Профиль
                </a>
            </li>
        @endauth

        {{-- Гость --}}
        @guest
          <li class="nav-item">
            <a href="{{ route('login.show') }}" class="btn btn-primary mb-3">Войти</a>
            <a href="{{ route('register.show') }}" class="btn btn-secondary mb-3">Регистрация</a>
          </li>
        @endguest

        {{-- Статическая страница --}}
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/about') }}">О нас</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
