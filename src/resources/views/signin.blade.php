@extends('blades.template')
@section('title', 'Регистрация')
@section('content')
  <h2 class="text-center mt-3">Регистрация</h2>
  @if ($errors->any())
    <div class="alert alert-danger text-center w-50 m-auto">
      @foreach ($errors->all() as $error)
        {{ $error }} <br>
      @endforeach
    </div>
  @endif

  @if (session('success'))
  <div class="alert alert-success w-50 m-auto">
    {{ session('success') }}
  </div>
  @endif
  <form action="{{ route('storeSignin') }}" method="post" class="w-50 m-auto">
  @csrf
    <div class="mt-3">
      <label for="firstname" class="form-label">Имя</label>
      <input type="text" name="firstname" id="firstname" class="form-control">
    </div>
    <div class="mt-3">
      <label for="lastname" class="form-label">Фамилия</label>
      <input type="text" name="lastname" id="lastname" class="form-control">
    </div>
    <div class="mt-3">
      <label for="phone" class="form-label">Телефон</label>
      <input type="phone" name="phone" id="phone" class="form-control">
    </div>
    <div class="mt-3">
      <label for="email" class="form-label">Почта</label>
      <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="mt-3">
      <label for="password" class="form-label">Пароль</label>
      <input type="password" name="password" id="password" class="form-control">
    </div>
    <input type="submit" class="btn btn-primary w-100 mt-3" value="Зарегестрироваться">
  </form>
@endsection