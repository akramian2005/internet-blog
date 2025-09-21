<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Мой блог</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          @auth
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-danger mb-3">Выйти</button>
              </form>
          @endauth
        </li>
        <li class="nav-item">
          {{-- Кнопки для гостя --}}
          @guest
            <a href="{{ route('login.show') }}" class="btn btn-primary mb-3">Войти</a>
            <a href="{{ route('register.show') }}" class="btn btn-secondary mb-3">Регистрация</a>
          @endguest
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/about') }}">О нас</a>

        </li>
      </ul>
    </div>
    
  </div>
</nav>