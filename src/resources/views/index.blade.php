@extends('blades.template')
@section('title', 'Главная')
@section('css')
  <link rel="stylesheet" href={{ asset('/css/index.css') }}>
@endsection

@vite(['resources/js/index.js'])


@section('content')
  <div class="content m-4 p-4 bg-light overflow-hidden banner d-flex flex-column justify-content-center align-items-center">
    <img src="images/logo.png" alt="" class="text-center" width="200px" height="200px">
    <h2 class="text-center text-light mb-4">Cоздаем лучшую атмосферу для семейных вечеров</h2>
  </div>
  <div class="content m-4 p-4 bg-light">
    <h2>О нас</h2>
    <p>{{ $about_us }}</p>
  </div>
  <div class="content m-4 p-4 bg-light">
    <h2>Акции</h2>
    <div class="slider-wrapper">
      <button id="prevBtn" class="btn btn-black"><</button>
      <div class="productSlider" id="slider">
        @foreach ($productsActions as $product)
          <div class="productCard card d-flex flex-column p-2 text-center">
            <img src="/images/products/{{ $product['img1'] }}" alt="{{ $product['img1'] }}" class="card-img-top">
            <div class="card-body">
              <p class="card-text">{{ $product['name_product'] }}</p>
              <p class="card-text">{{ $product['price'] }}руб</p>
              <button class="btn btn-primary">В корзину</button>
            </div>
          </div>
        @endforeach
      </div>
      <button class="btn btn-black" id="nextBtn">></button>
    </div>
  </div>
  <div class="content m-4 p-4 bg-light">
    <h2>Новинки</h2>
    <div class="slider-wrapper">
      <button id="prevBtn2" class="btn btn-black"><</button>
      <div class="productSlider" id="slider2">
        @foreach ($productsNews as $product)
          <div class="productCard card d-flex flex-column p-2 text-center">
            <img src="/images/products/{{ $product['img1'] }}" alt="{{ $product['img1'] }}" class="card-img-top">
            <div class="card-body">
              <p class="card-text">{{ $product['name_product'] }}</p>
              <p class="card-text">{{ $product['price'] }}руб</p>
              <button class="btn btn-primary">В корзину</button>
            </div>
          </div>
        @endforeach
      </div>
      <button class="btn btn-black" id="nextBtn2">></button>
    </div>
  </div>
  <div class="content m-4 p-4 bg-light">
    <h2>Адрес</h2>
    <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/56/chelyabinsk/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Челябинск</a><a href="https://yandex.ru/maps/56/chelyabinsk/house/ulitsa_stalevarov_21/YkgYcgdjQUcOQFtvfX50d39gYA==/?ll=61.403541%2C55.256388&mode=search&sctx=ZAAAAAgAEAAaKAoSCZjArbt5TE5AERlYx%2FFDa0xAEhIJ%2B1xtxf6y0D8RgIC1ateEvD8iBgABAgMEBSgKOABA2JwGSAFqAnJ1nQHNzMw9oAEAqAEAvQEKMKPOwgEZAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIICF9GB0YLQsNC70LXQstCw0YDQvtCyIDIxigIAkgIAmgIMZGVza3RvcC1tYXBz&sll=61.403829%2C55.256334&sspn=0.010538%2C0.004688&text=%D1%81%D1%82%D0%B0%D0%BB%D0%B5%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%2021&utm_medium=mapframe&utm_source=maps&z=16.73" style="color:#eee;font-size:12px;position:absolute;top:14px;">Улица Сталеваров, 21 — Яндекс Карты</a><iframe src="https://yandex.ru/map-widget/v1/?ll=61.403541%2C55.256388&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg1NjAzMjE0MhJF0KDQvtGB0YHQuNGPLCDQp9C10LvRj9Cx0LjQvdGB0LosINGD0LvQuNGG0LAg0KHRgtCw0LvQtdCy0LDRgNC-0LIsIDIxIgoNhZ11QhV8Bl1C&sctx=ZAAAAAgAEAAaKAoSCZjArbt5TE5AERlYx%2FFDa0xAEhIJ%2B1xtxf6y0D8RgIC1ateEvD8iBgABAgMEBSgKOABA2JwGSAFqAnJ1nQHNzMw9oAEAqAEAvQEKMKPOwgEZAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIICF9GB0YLQsNC70LXQstCw0YDQvtCyIDIxigIAkgIAmgIMZGVza3RvcC1tYXBz&sll=61.403829%2C55.256334&sspn=0.010538%2C0.004688&text=%D1%81%D1%82%D0%B0%D0%BB%D0%B5%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%2021&z=16.73" width="100%" height="500" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>

  </div>

  <div class="content m-4 p-4 bg-light">
    <h2>Отзывы</h2>
    @foreach ($reviews as $review)
      <div class="bg-white border-1 border-black p-2 m-3 rounded-3">
        <h3>User</h3>
         @for ($i = 0; $i < $review['rating']; $i++)
          ⭐️
         @endfor
         <p>{{ $review['text'] }}</p>
      </div>
    @endforeach
  </div>
@endsection