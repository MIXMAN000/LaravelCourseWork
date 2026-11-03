<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @yield('css')

</head>

<body>
  <header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="{{ route('index') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <img class="bi me-2" width="80px" height="80px" src="/images/logo.png">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="{{ route('index') }}" class="nav-link px-2 text-white">Главная</a></li>
          <li><a href="{{ route('catalog') }}" class="nav-link px-2 text-white">Каталог</a></li>
          <li><a href="{{ route('news') }}" class="nav-link px-2 text-white">Новости</a></li>
          <li><a href="{{ route('contact') }}" class="nav-link px-2 text-white">Контакты</a></li>
          <li><a href="{{ route('deliveryInfo') }}" class="nav-link px-2 text-white">Доставка и оплата</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" method="get" action="#">
          <input type="search" class="form-control form-control-dark" placeholder="Поиск" aria-label="Search" name="search">
        </form>
        @guest
        <div class="text-end">
          <a href="{{ route('login') }}" type="button" class="btn btn-outline-light me-2">Вход</a>
          <a  href="{{ route('signin') }}"type="button" class="btn btn-warning">Регистрация</a>
        </div>
        @endguest

        @auth
        <div class="dropdown">
          <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->firstname }}
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('profile') }}">Профиль</a></li>
            <li><a class="dropdown-item" href="{{ route('basket') }}">Корзина</a></li>
            <li><a class="dropdown-item" href="{{ route('orders') }}">Мои заказы</a></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Выход</a></li>
          </ul>
        </div>
        @endauth

      </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="bg-dark text-white p-4">
    <div class="address">
      <h3>Адрес:</h3>
      <p>г. Челябинск, ул. Сталеваров 21, кв. 27</p>
    </div>
    <div class="email">
      <h3>Эл. почта</h3>
      <p>mishabogatov2007@gmail.com</p>
    </div> 
    <div class="phoneNumber">
      <h3>Телефон:</h3>
      <p>8-900-083-92-46</p>
    </div>
    <div class="sociality">
      <h3>Соц. сети</h3>
      <div class="d-flex flex-row gap-2">
        <a href="vk.com"><img src="/images/sociality/vk.png" alt="vk.com" class="img-fluid"></a>
        <a href="telegram.org"><img src="/images/sociality/telegram.png" alt="telegram" class="img-fluid"></a>
        <a href="youtube.com"><img src="/images/sociality/youtube.png" alt="youtube" class="img-fluid"></a>
      </div>
    </div>
  </footer>
</body>

</html>