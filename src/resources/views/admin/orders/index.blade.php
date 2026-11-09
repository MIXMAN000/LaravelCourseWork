@extends('admin.layout')
@section('title', 'Заказы')
@section('content')
<div class="admin-page-heading"><div><p class="admin-eyebrow">Продажи</p><h1>Заказы</h1><p>Меняйте статусы и просматривайте состав заказов.</p></div></div>
<div class="row g-3 mb-4">
@foreach($orderStats as $status => $count)
    <div class="col-6 col-xl-3"><a href="{{ route('admin.orders.index', ['status' => $status]) }}" class="mini-stat text-decoration-none"><span>{{ $status }}</span><strong>{{ $count }}</strong></a></div>
@endforeach
</div>
<section class="admin-panel">
    <form class="admin-filters order-filters" method="get"><div class="search-control flex-grow-1"><svg><use href="#i-search"/></svg><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Номер, имя или электронная почта"></div><select class="form-select" name="status"><option value="">Все статусы</option>@foreach($statuses as $status)<option @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select><select class="form-select" name="payment"><option value="">Все способы оплаты</option>@foreach($paymentTypes as $payment)<option @selected(request('payment') === $payment)>{{ $payment }}</option>@endforeach</select><input class="form-control date-filter" type="date" name="date_from" value="{{ request('date_from') }}" title="Дата от"><input class="form-control date-filter" type="date" name="date_to" value="{{ request('date_to') }}" title="Дата до"><button class="btn btn-primary">Применить</button>@if(request()->hasAny(['q','status','payment','date_from','date_to']))<a href="{{ route('admin.orders.index') }}" class="btn btn-light">Сбросить</a>@endif</form>
    <div class="table-responsive"><table class="table admin-table align-middle mb-0"><thead><tr><th>№ заказа</th><th>Пользователь</th><th>Тип оплаты</th><th>Статус</th><th>Причина отмены</th><th>Сумма</th><th>Состав</th></tr></thead><tbody>
    @forelse($orders as $order)
        <tr>
            <td><strong class="text-primary">#{{ $order->id }}</strong><small>{{ optional($order->created_at)->format('d.m.Y H:i') }}</small></td>
            <td>{{ $order->orderUser?->firstname }} {{ $order->orderUser?->lastname }}<small>{{ $order->orderUser?->email }}</small></td>
            <td>{{ $order->payment_type }}</td>
            <td><form method="post" action="{{ route('admin.orders.status', $order) }}" class="status-form">@csrf @method('PATCH')<select class="form-select form-select-sm" name="status" onchange="this.form.submit()">@foreach($statuses as $status)<option @selected($order->status === $status)>{{ $status }}</option>@endforeach</select></form></td>
            <td>{{ $order->cancellation_reason ?: '—' }}</td><td><strong>{{ number_format((float) ($order->sum ?? 0), 0, ',', ' ') }} ₽</strong></td><td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">Посмотреть ({{ $order->items->sum('count') }})</a></td>
        </tr>
    @empty<tr><td colspan="7" class="empty-state">Заказы не найдены.</td></tr>@endforelse
    </tbody></table></div><div class="panel-pagination">{{ $orders->links() }}</div>
</section>
@endsection
