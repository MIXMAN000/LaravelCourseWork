@extends('admin.layout')
@section('title', 'Обзор')
@section('content')
<div class="admin-page-heading">
    <div><p class="admin-eyebrow">Главная</p><h1>Обзор</h1><p>Ключевые показатели магазина и последние заказы.</p></div>
</div>

<div class="row g-3 mb-4">
    @php
        $cards = [
            ['Товары', $stats['products'], 'admin.products.index', 'i-box', 'blue'],
            ['Категории', $stats['categories'], 'admin.categories.index', 'i-layers', 'violet'],
            ['Заказы', $stats['orders'], 'admin.orders.index', 'i-cart', 'orange'],
            ['Пользователи', $stats['users'], 'admin.users.index', 'i-users', 'green'],
            ['Отзывы', $stats['reviews'], 'admin.reviews.index', 'i-chat', 'pink'],
            ['Новости', $stats['posts'], 'admin.posts.index', 'i-news', 'cyan'],
        ];
    @endphp
    @foreach ($cards as [$label, $value, $route, $icon, $color])
    <div class="col-12 col-sm-6 col-xl-4">
        <a href="{{ route($route) }}" class="admin-stat-card text-decoration-none">
            <span class="stat-icon {{ $color }}"><svg><use href="#{{ $icon }}"/></svg></span>
            <span><small>{{ $label }}</small><strong>{{ $value }}</strong></span>
            <span class="stat-arrow">→</span>
        </a>
    </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-12 col-xl-4">
        <section class="admin-panel h-100">
            <div class="panel-heading"><div><h2>Статусы заказов</h2><p>Текущее распределение</p></div></div>
            <div class="status-list">
                @foreach ($orderStats as $status => $count)
                <a href="{{ route('admin.orders.index', ['status' => $status]) }}">
                    <span class="status-dot status-{{ str_replace([' ', 'ё'], ['-', 'е'], mb_strtolower($status)) }}"></span>
                    <span>{{ $status }}</span><strong>{{ $count }}</strong>
                </a>
                @endforeach
            </div>
        </section>
    </div>
    <div class="col-12 col-xl-8">
        <section class="admin-panel">
            <div class="panel-heading"><div><h2>Последние заказы</h2><p>Недавно оформленные покупки</p></div><a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary btn-sm">Все заказы</a></div>
            <div class="table-responsive">
                <table class="table admin-table align-middle mb-0">
                    <thead><tr><th>Заказ</th><th>Покупатель</th><th>Статус</th><th>Сумма</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($recentOrders as $order)
                        <tr><td><strong>#{{ $order->id }}</strong><small>{{ optional($order->created_at)->format('d.m.Y H:i') }}</small></td><td>{{ $order->orderUser?->firstname }} {{ $order->orderUser?->lastname }}</td><td><span class="order-status">{{ $order->status }}</span></td><td>{{ number_format((float) ($order->sum ?? 0), 0, ',', ' ') }} ₽</td><td><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.orders.show', $order) }}">Открыть</a></td></tr>
                    @empty
                        <tr><td colspan="5" class="empty-state">Заказов пока нет.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
