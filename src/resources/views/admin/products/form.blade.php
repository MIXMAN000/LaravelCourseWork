@extends('admin.layout')
@php($editing = $product->exists)
@section('title', $editing ? 'Редактирование товара' : 'Новый товар')
@section('content')
<div class="admin-page-heading">
    <div><a href="{{ route('admin.products.index') }}" class="admin-back">← Все товары</a><h1>{{ $editing ? 'Редактирование товара' : 'Новый товар' }}</h1><p>{{ $editing ? 'Обновите данные карточки и сохраните изменения.' : 'Заполните информацию для новой карточки.' }}</p></div>
</div>
<form method="post" enctype="multipart/form-data" action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf @if($editing) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <section class="admin-panel form-panel">
                <h2>Основная информация</h2>
                <div class="mb-3"><label class="form-label">Название</label><input class="form-control form-control-lg" name="name_product" value="{{ old('name_product', $product->name_product) }}" required></div>
                <div class="row g-3"><div class="col-md-6"><label class="form-label">Категория</label><select class="form-select" name="id_category" required><option value="">Выберите категорию</option>@foreach($categories as $category)<option value="{{ $category->id_category }}" @selected(old('id_category', $product->id_category) == $category->id_category)>{{ $category->category }}</option>@endforeach</select></div><div class="col-md-3"><label class="form-label">Цена, ₽</label><input type="number" min="0" class="form-control" name="price" value="{{ old('price', $product->price) }}" required></div><div class="col-md-3"><label class="form-label">Остаток</label><input type="number" min="0" class="form-control" name="inventory" value="{{ old('inventory', $product->inventory ?? 0) }}" required></div></div>
                <div class="mt-3"><label class="form-label">Характеристики</label><textarea class="form-control" rows="4" name="characteristic" required>{{ old('characteristic', $product->characteristic) }}</textarea></div>
                <div class="mt-3"><label class="form-label">Описание</label><textarea class="form-control" rows="7" name="description" required>{{ old('description', $product->description) }}</textarea></div>
            </section>
        </div>
        <div class="col-12 col-xl-4">
            <section class="admin-panel form-panel mb-4">
                <h2>Публикация</h2>
                <div class="form-check form-switch mb-3"><input type="hidden" name="action" value="0"><input class="form-check-input" type="checkbox" role="switch" id="action" name="action" value="1" @checked(old('action', $product->action))><label class="form-check-label" for="action">Товар участвует в акции</label></div>
                <div class="form-check form-switch"><input type="hidden" name="news" value="0"><input class="form-check-input" type="checkbox" role="switch" id="news" name="news" value="1" @checked(old('news', $product->news))><label class="form-check-label" for="news">Показывать как новинку</label></div>
            </section>
            <section class="admin-panel form-panel">
                <h2>Изображения</h2>
                @foreach(['img1' => 'Главное изображение', 'img2' => 'Второе изображение', 'img3' => 'Третье изображение'] as $field => $label)
                    <div class="mb-3"><label class="form-label">{{ $label }}</label>@if($editing && $product->{$field})<div class="current-image"><img src="{{ asset('images/products/'.$product->{$field}) }}" alt=""></div>@endif<input class="form-control" type="file" name="{{ $field }}" accept="image/*" @required(!$editing && $field === 'img1')></div>
                @endforeach
                <small class="text-secondary">JPG, PNG, WEBP до 4 МБ. Если для нового товара выбрать одно фото, оно будет использовано во всех позициях.</small>
            </section>
        </div>
    </div>
    <div class="form-actions"><a href="{{ route('admin.products.index') }}" class="btn btn-light">Отмена</a><button class="btn btn-primary btn-lg">{{ $editing ? 'Сохранить изменения' : 'Добавить товар' }}</button></div>
</form>
@endsection
