@extends('blades.template')
@section('title', 'Корзина')

@section('content')
  @if ($count_products == 0)
    <div class="m-4 bg-light rounded h-100 d-flex flex-column justify-content-start align-items-center">
      <h3 class="p-4">В корзине пока ничего нет</h3>
      <a href="{{ route('catalog') }}" class="btn btn-primary text-center">В каталог</a>
    </div>
  @else
  <div class="container-fluid">
    <div class="row">
      <div class="col-8 p-4">
        <div class="bg-light h-100">
          <div class="d-flex justify-content-between align-items-center p-4">
            <h3 class="display-6">Корзина</h3>
            <p class="m-0">Товаров: {{ $count_products }}</p>
          </div>
            @if (session('success'))
              <div class="alert alert-success w-100">{{ session('success') }}</div>
            @endif
          @foreach ($baskets as $basket)
            <div class="rounded bg-white m-4 p-4 basketCard">
              <div class="">
                <img src="/images/products/{{ $basket->basketProduct->img1 }}" alt="img" width="200">
              </div>
              <div class="d-flex flex-column justify-content-between align-items-start p-3">
                <h5>{{ $basket->basketProduct->name_product }}</h5>
                <form action="{{ route('deleteBasket') }}" method="post">
                  @csrf
                  <input type="text" hidden name="basket_id" value="{{ $basket->basket_id }}">
                  <input type="submit" value="Удалить ❌" >
                </form>
              </div>
              <div class="d-flex flex-column justify-content-between align-items-start p-3">
                <h5>{{ $basket->basketProduct->price }} руб.</h5>
                <div class="d-inline-flex justify-content-center align-items-center gap-3">
                  <form action="{{ route('minusCountBasket') }}" method="post">
                    @csrf
                    <input type="text" hidden name="basket_id" value="{{ $basket->basket_id }}">
                    <input type="submit" class="btn btn-light" id="btnMinus" value="-">
                  </form>
                    <p class="m-0">{{ $basket->count }}</p>
                  <form action="{{ route('plusCountBasket') }}" method="post">
                    @csrf
                    <input type="text" hidden name="basket_id" value="{{ $basket->basket_id }}">
                    <input type="submit" class="btn btn-light" id="btnPlus" value="+">
                  </form>
                </div>
                <h5>Итого: {{ $basket->basketProduct->price * $basket->count }}</h5>
              </div>
            </div>
          @endforeach
          <div class="rounded">
            
          </div>
        </div>
      </div>
      <div class="col-4 p-4 ps-0">
        <div class="bg-light h-100">
          <h3 class="display-6 p-4 py-0 pt-3">Оформить заказ</h3>
          <p class="p-4 py-0">Наиенований: {{ $count_products }}</p>
          <p class="p-4 py-0">Всего товаров: {{ $totalCountProducts }}</p>
          <h3 class=" p-4 py-0">Итого: {{ $basket_price }}</h3>
          <div class="p-4 py-2">
            <a class="btn btn-primary w-100" href="{{ route('checkout') }}">Оформить заказ</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  
  
@endsection

<script>
document.addEventListener('DOMContentLoaded', ()=>{
  const counter = document.getElementById('counter');
  let count = 1

  document.getElementById('btnMinus').addEventListener('click', ()=>{
    if (counter.value > 1){
      counter.value--;
    }
  });
  document.getElementById('btnPlus').addEventListener('click', ()=>{
    counter.value++
  });
})
</script>