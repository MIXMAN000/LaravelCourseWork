@extends('blades.template')
@section('title', $product->name_product)
@vite(['resources/js/cardSlider.js'])
@section('content')
  <a href="{{ url()->previous() }}" class="btn btn-secondary m-4 mb-0">Назад</a>
  <h2 class="mt-4 ms-4">{{ $product->name_product }}</h2>
  <div class="cardGrid mx-4 p-4">
    <div class="image d-flex flex-row justify-content-between align-items-center position-relative" id="slider">
      <button type="button" class="btn" id="prevBtn"><</button>
      <img src="/images/products/{{ $product->img1 }}" alt="{{ $product->img1 }}">
      <img src="/images/products/{{ $product->img2 }}" alt="{{ $product->img2 }}">
      <img src="/images/products/{{ $product->img3 }}" alt="{{ $product->img3 }}">
      <button class="btn" id="nextBtn" type="button">></button>
    </div>
    <div class="miniImg">
      <button id="photo1"><img src="/images/products/{{ $product->img1 }}" alt="{{ $product->img1 }}"></button>
      <button id="photo2"><img src="/images/products/{{ $product->img2 }}" alt="{{ $product->img2 }}"></button>
      <button id="photo3"><img src="/images/products/{{ $product->img3 }}" alt="{{ $product->img3 }}"></button>
    </div>
    <div class="info border-1 border-black rounded-2 p-3">

      @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger w-100">
          {{ $error }}
        </div>
        @endforeach
      @endif
      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif
      <h3>{{ $product->name_product }}</h3>
      <p>Цена: {{ $product->price }}</p>
      <div class="counter d-flex flex-row gap-1 justify-asdfcontent-center align-items-center mb-3">
      @if ($user == false)
        <p>Что бы добавить товар в корзину, нужно <a href="{{ route('login') }}">авторизоваться</a></p>
      @elseif ($product->inventory <= 0)
        <div class="alert alert-secondary mb-0">Товар закончился</div>
      @elseif ($inBasket == true)
        <a href="{{ route('basket') }}" class="btn btn-primary">Уже в корзине </a>
      @else
      <form action="{{ route('addToBasket') }}" class="d-inline-flex justify-content-start align-items-center gap-3" method="post"> 
      @csrf
        <button type="button" class="btn btn-light" id="btnMinus">-</button>
        <input type="text" hidden value="{{ $product->id_product }}" name="id_product">
        <input type="number" class="m-0 no-snippers" id="counter" value="1" min="1" max="{{ $product->inventory }}" name="product_count">
        <button type="button" class="btn btn-light" id="btnPlus">+</button>

        <button type="submit" class="btn btn-primary">В корзину</button>
      </form>
      @endif
      </div>
      <h4>Категория: {{ $product->productCategory->category }}</h4>
      @if ($product->action == 1)
        <h5>Акция!</h5>
      @endif
      @if ($product->news == 1)
        <h5>Новинка!</h5>
      @endif
      <h4>Характеристики: </h4>
      <p>{{ $product->characteristic }}</p>
      <h4>Описание:</h4>
      <p>{{ $product->description }}</p>
      <h4>Осталось: {{ $product->inventory }}</h4>
    </div>
  </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', ()=>{
  const counter = document.getElementById('counter');
  const minusButton = document.getElementById('btnMinus');
  const plusButton = document.getElementById('btnPlus');

  if (!counter || !minusButton || !plusButton) {
    return;
  }

  minusButton.addEventListener('click', ()=>{
    if (counter.value > 1){
      counter.value--;
    }
  });
  plusButton.addEventListener('click', ()=>{
    if (Number(counter.value) < Number(counter.max)) {
      counter.value++;
    }
  });
})
</script>
