@extends('blades.profileTemp')

@section('profile')
  <h2>Личная информация</h2>
  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <div class="alert alert-danger w-50">
        {{ $error }} <br>
      </div>
    @endforeach
  @endif
  @if (session('success'))
    <div class="alert alert-success w-50">
      {{ session('success') }}
    </div>
  @endif
  <div class="d-flex flex-column gap-4 position-relative">
    <div class="bg-white w-50 rounded px-3 border border-black py-4 d-flex flex-row justify-content-between" id="userInfo">
      <p class="">Имя и фамилия</p>
      <span>{{ $user->firstname }} {{ $user->lastname }}</span>
      <span><button id="editFirstName" data-bs-toggle="modal" data-bs-target="#editName"><img src="/images/icons/edit.png" alt="edit" width="24"></button></span>
    </div>
    <div class="bg-white w-50 rounded px-3 border border-black py-4 d-flex flex-row justify-content-between" id="userInfo">
      <p class="">Почта</p>
      <span>{{ $user->email }}</span>
    </div>
    <div class="bg-white w-50 rounded px-3 border border-black py-4 d-flex flex-row justify-content-between" id="userInfo">
      <p class="">Номер телефона</p>
      <span>{{ $user->phone }}</span>
      <span><button id="editUserPhone" data-bs-toggle="modal" data-bs-target="#editPhone"><img src="/images/icons/edit.png" alt="edit" width="24"></button></span>
    </div>
  </div>

<div class="modal fade" id="editName" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Имя и фамилия</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('editName') }}" method="post" class="w-50 m-auto">
          <div class="m-3">
            <label for="firstName" class="form-label">Имя</label>
            <input type="text" name="firstName" id="firstName" class="form-control" value="{{ $user->firstname }}">
          </div>
          <div class="m-3">
            <label for="lastName" class="form-label">Фамилия</label>
            <input type="text" name="lastName" id="lastName" class="form-control" value="{{ $user->lastname }}">
          </div>
          <input type="submit" value="Сохранить" class="btn btn-primary w-100">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editPhone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Изменение телефона</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('editPhone') }}" method="post" class="w-50 m-auto">
          <div class="m-3">
            <label for="phone" class="form-label">Новый телефон</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
          </div>
          <input type="submit" value="Сохранить" class="btn btn-primary w-100">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>



@endsection
