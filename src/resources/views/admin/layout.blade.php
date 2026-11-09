<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Панель администратора') — Настолка</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
<svg class="d-none" aria-hidden="true">
    <symbol id="i-grid" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></symbol>
    <symbol id="i-box" viewBox="0 0 24 24"><path d="m4 7 8-4 8 4v10l-8 4-8-4V7Z"/><path d="m4 7 8 4 8-4M12 11v10"/></symbol>
    <symbol id="i-layers" viewBox="0 0 24 24"><path d="m12 2 9 5-9 5-9-5 9-5Z"/><path d="m3 12 9 5 9-5M3 17l9 5 9-5"/></symbol>
    <symbol id="i-cart" viewBox="0 0 24 24"><path d="M3 3h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 7H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24"><circle cx="9" cy="8" r="4"/><path d="M2 21v-2a6 6 0 0 1 6-6h2a6 6 0 0 1 6 6v2M16 4a4 4 0 0 1 0 8M18 14a6 6 0 0 1 4 5v2"/></symbol>
    <symbol id="i-chat" viewBox="0 0 24 24"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3 1.7-5A8 8 0 1 1 21 15Z"/></symbol>
    <symbol id="i-news" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h4v4H7zM14 8h3M14 12h3M7 16h10"/></symbol>
    <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></symbol>
    <symbol id="i-menu" viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></symbol>
</svg>

<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Настолка">
            <span>Настолка</span>
        </a>
        <hr>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><svg><use href="#i-grid"/></svg><span>Обзор</span></a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><svg><use href="#i-box"/></svg><span>Товары</span></a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><svg><use href="#i-layers"/></svg><span>Категории</span></a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><svg><use href="#i-cart"/></svg><span>Заказы</span></a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><svg><use href="#i-users"/></svg><span>Пользователи</span></a>
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}"><svg><use href="#i-chat"/></svg><span>Отзывы</span></a>
            <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"><svg><use href="#i-news"/></svg><span>Новости</span></a>
        </nav>
        <div class="admin-sidebar-footer">
            <a href="{{ route('index') }}">← Вернуться на сайт</a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="btn admin-menu-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileAdminNav" aria-label="Открыть меню"><svg><use href="#i-menu"/></svg></button>
            <strong>Панель администратора</strong>
            <div class="admin-user dropdown ms-auto">
                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile') }}">Профиль</a></li>
                    <li><a class="dropdown-item" href="{{ route('index') }}">Открыть сайт</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Выйти</a></li>
                </ul>
            </div>
        </header>

        <main class="admin-content">
            @include('admin.partials.alerts')
            @yield('content')
        </main>
    </div>
</div>

<div class="offcanvas offcanvas-start admin-mobile-nav" tabindex="-1" id="mobileAdminNav">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Администрирование</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body admin-nav">
        <a href="{{ route('admin.dashboard') }}"><svg><use href="#i-grid"/></svg>Обзор</a>
        <a href="{{ route('admin.products.index') }}"><svg><use href="#i-box"/></svg>Товары</a>
        <a href="{{ route('admin.categories.index') }}"><svg><use href="#i-layers"/></svg>Категории</a>
        <a href="{{ route('admin.orders.index') }}"><svg><use href="#i-cart"/></svg>Заказы</a>
        <a href="{{ route('admin.users.index') }}"><svg><use href="#i-users"/></svg>Пользователи</a>
        <a href="{{ route('admin.reviews.index') }}"><svg><use href="#i-chat"/></svg>Отзывы</a>
        <a href="{{ route('admin.posts.index') }}"><svg><use href="#i-news"/></svg>Новости</a>
    </div>
</div>
@stack('scripts')
</body>
</html>
