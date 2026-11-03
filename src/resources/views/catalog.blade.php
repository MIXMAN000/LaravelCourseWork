@extends('blades/template')
@section('title', 'Каталог')

@section('content')

  <div class="h d-flex flex-row gap-3 p-4 m-4 mb-0 align-items-center justify-content-between">
    <h1 class="">Каталог</h1>
    <form action="{{ route('catalogSort') }}" method="get" class="d-flex flex-row gap-2">
      <select name="sort" id="sort" class="form-control">
        <option value="lowestPrice">Сначала дешевле</option>
        <option value="highestPrice">Сначала дороже</option>
        <option value="firstNews">Сначала новый</option>
        <option value="firstOlds">Сначала старые</option>
      </select>
      <button class="btn btn-primary" type="submit">Применить</button>

    </form>
  </div>

  <div class="catalog-grid m-4 mt-0 p-4">
    <div class="border-1 border-black p-3 rounded-2">
      <h3>Категория:</h3>
      <form action="{{ route('catalogCategory') }}" method="get">
        @foreach ($categories as $category)
          <div class="form-item">
            <input type="radio" id="{{ $category['category'] }}" name="category" value="{{ $category->id_category }}" {{ $category_id == $category->id_category ? 'checked' : '' }} >
            <label for="{{ $category['category'] }}">{{ $category['category'] }}</label>
          </div>
        @endforeach
        <div class="form-item">
          <input type="radio" id="actions" name="category" value="action" {{ $category_id == 'action' ? 'checked' : '' }}>
          <label for="actions">По акции</label>
        </div>
        <div class="form-item">
          <input type="radio" id="news" name="category" value="news" {{ $category_id == 'news' ? 'checked' : '' }}>
          <label for="news">Новинки</label>
        </div>
        <button class="btn btn-primary mt-2" type="submit">Применить</button>
      </form>
    </div>
    <div class="catalog border-1 border-black p-3 rounded-2">
      @if ($error)
        <div class="alert alert-warning w-100">
            {{ $error }}
        </div>
      @endif
      @foreach ($products as $product)
        <a class="text-decoration-none" href="{{ route('productCard', $product->id_product) }}"><div class="card p-3 d-flex flex-column justify-content-between align-items-center">
          <img src="/images/products/{{ $product['img1'] }}" alt="{{ $product['name_product'] }}" class="card-img-top">
          <div class="card-body text-center d-flex flex-column justify-content-between align-items-center">
            <h4>{{ $product['name_product'] }}</h4>
            <p>{{ $product['price'] }}руб.</p>
            <p>Категория: {{ $product->ProductCategory->category }}</p>
            @if ($product['action'] == 1)
              <p>Акция!</p>
            @endif
            @if ($product['news'] == 1)
              <p>Новинка!</p>
            @endif
            @if ($product->inventory < 5)
              <p>Осталось всего: {{ $product->inventory }}</p>
            @endif
            <button class="btn btn-primary">В корзину</button>
          </div>
        </div></a>
        
      @endforeach
    </div>
  </div>
  
@endsection