@extends('blades.template')
@section('title', 'Профиль')
@section('content')
  <h1 class="text-center mt-3">Профиль</h1>
  
  <div class="container overflow-hidden">
    <div class="row gx-4">
      <div class="col-3">
        <div class="bg-light d-flex flex-column gap-4 justify-content-start align-items-center py-4 h-100">
          <a href="{{ route('profile') }}" class="w-75 btn  btn-primary cursor-pointer">Личная информация</a>
          <a href="{{ route('orders') }}" class="w-75 btn  btn-primary">Мои заказы</a>
          <a href="{{ route('ordersHistory') }}" class="w-75 btn  btn-primary">История заказов</a>
          <a href="{{ route('logout') }}" class="w-75 btn  btn-primary">Выход</a>
        </div>
      </div>
      <div class="col-9">
        <div class="bg-light p-4 h-100">
          @yield('profile')
        </div>
      </div>
    </div>
  </div>
@endsection