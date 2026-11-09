@extends('admin.layout')
@section('title', 'Товары')
@section('content')
<div class="admin-page-heading">
    <div><p class="admin-eyebrow">Каталог</p><h1>Товары</h1><p>Редактируйте карточки, цены и остатки.</p></div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-lg">＋ Добавить товар</a>
</div>
<section class="admin-panel">
    <form class="admin-filters" method="get">
        <div class="search-control"><svg><use href="#i-search"/></svg><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Поиск по названию"></div>
        <select class="form-select" name="category"><option value="">Все категории</option>@foreach ($categories as $category)<option value="{{ $category->id_category }}" @selected(request('category') == $category->id_category)>{{ $category->category }}</option>@endforeach</select>
        <button class="btn btn-primary">Применить</button>
        @if(request()->hasAny(['q','category']))<a href="{{ route('admin.products.index') }}" class="btn btn-light">Сбросить</a>@endif
    </form>
    <div class="table-responsive">
        <table class="table admin-table align-middle mb-0">
            <thead><tr><th>Товар</th><th>Категория</th><th>Цена</th><th>Остаток</th><th>Метки</th><th></th></tr></thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <td><div class="product-cell"><img src="{{ asset('images/products/'.$product->img1) }}" alt=""><div><strong>{{ $product->name_product }}</strong><small>#{{ $product->id_product }}</small></div></div></td>
                    <td>{{ $product->ProductCategory?->category ?? '—' }}</td>
                    <td><strong>{{ number_format($product->price, 0, ',', ' ') }} ₽</strong></td>
                    <td><span class="stock-badge {{ $product->inventory < 5 ? 'low' : '' }}">{{ $product->inventory }} шт.</span></td>
                    <td>@if($product->action)<span class="badge text-bg-danger">Акция</span>@endif @if($product->news)<span class="badge text-bg-primary">Новинка</span>@endif</td>
                    <td class="text-end"><a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary btn-sm">Редактировать</a></td>
                </tr>
            @empty<tr><td colspan="6" class="empty-state">Товары не найдены.</td></tr>@endforelse
            </tbody>
        </table>
    </div>
    <div class="panel-pagination">{{ $products->links() }}</div>
</section>
@endsection
