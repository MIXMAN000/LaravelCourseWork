@extends('blades.template')
@section('title', 'Вход')
@section('content')
  <h2 class="text-center mt-3">Вход</h2>
  @if ($errors->any())
    <div class="alert alert-danger text-center">
      @foreach ($errors->all() as $error)
        {{ $error }} <br>
      @endforeach
    </div>
  @endif

  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif
  <form action="{{ route('storeLogin') }}" method="post" class="w-50 m-auto">
    <div class="mt-3">
      <label for="email" class="form-label">Почта</label>
      <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="mt-3">
      <label for="password" class="form-label">Пароль</label>
      <input type="password" name="password" id="password" class="form-control">
    </div>
    <input type="submit" value="Войти" class="w-100 mt-3 btn btn-primary">
  </form>
@endsection