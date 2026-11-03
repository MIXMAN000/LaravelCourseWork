@extends('blades.template')
@section('title', 'Оформление заказа')
@section('content')

<div class="container">
  <h2 class="display-6 p-4">Оформление заказа</h2>
  <div class="bg-light p-4 my-3">
  <p>Товаров: {{ $totalCountProducts }}</p>
    @foreach ($baskets as $basket)  
      <div class="row my-4">
        <div class="col-10">
          {{ $basket->basketProduct->name_product }}
        </div>
        <div class="col-1">{{ $basket->count }} шт</div>
        <div class="col-1">{{ $basket->count * $basket->basketProduct->price }} руб.</div>
      </div>
    @endforeach
    <div class="d-flex flex-row justify-content-end align-items-center">
      <h3>Итого: {{ $basket_price }} руб. </h3>
    </div>
  </div>

  <div class="bg-light p-4 my-3">
    <h4 for="adress">Выберите пункт выдачи заказа:</h4>
    <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/56/chelyabinsk/search/CDEK/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">CDEK в Челябинске</a><a href="https://yandex.ru/maps/56/chelyabinsk/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Челябинск</a><iframe src="https://yandex.ru/map-widget/v1/?display-text=CDEK&ll=61.418502%2C55.160586&mode=search&sctx=ZAAAAAgBEAAaKAoSCd9vtOOGs05AEUDdQIF3lEtAEhIJEVFM3gCz4D8RnglNEkvKzT8iBgABAgMEBSgKOABAkpEHSAFiM3ByaWNlc19zbmlwcGV0c19yYW5raW5nX21vZGVsPW1vZGVsXzIwMjUxMTE4XzE1NTM1OWIrcHJpY2VzX3NuaXBwZXRzX3JhbmtpbmdfbW9kZWxfdGhyZXNob2xkPTAuMWI6cmVhcnI9c2NoZW1lX0xvY2FsL0dlby9TdWJ0aXRsZXMvVXNlUGluR29vZHNQcmljZUZvcm11bGE9MWoCcnWdAc3MzD2gAQCoAQC9AeG4JkLCAY0BqvTumCWyjP%2Fh3gGZiv67nAXOqvXblwGvxeTUwgTJ0snruQKB3Kj1nQX7xeea6gbRi8PLBMnO6uXpAdHlmLZFvfL939kGn%2Bzrg8sBh63BuAax6sq5lgTE4KWprAKlzc7fSIGSjtcGhbWc%2FiHR67OvzwHhzK%2BmuATs55jeyAO2otC%2BsAGhjMyHZN7I5bFXggIYKChjaGFpbl9pZDooMjcyODg5NTU4KSkpigIAkgIAmgIMZGVza3RvcC1tYXBzqgIJMjcyODg5NTU4sAIB&sll=61.418502%2C55.160586&sspn=0.493701%2C0.220178&text=%7B%22text%22%3A%22CDEK%22%2C%22what%22%3A%5B%7B%22attr_name%22%3A%22chain_id%22%2C%22attr_values%22%3A%5B%22272889558%22%5D%7D%5D%7D&z=11.08" width="100%" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
  </div>

  <form action="{{ route('storeCheckuot') }}" method="post">
  @csrf
  <input type="text" hidden name="sum" value="{{ $basket_price }}">
    <div class="bg-light my-3 p-4">
      <h4>Выберите способ оплаты:</h4>
      <div class="mt-3">
        <input type="radio" name="payment" id="card" class="form-check-input me-2" value="Банковской картой">
        <label for="card" class="form-check-label">Банковской картой</label>
      </div>
      <div class="mt-3">
        <input type="radio" name="payment" id="sbp" class="form-check-input me-2" checked value="СБП">
        <label for="sbp" class="form-check-label">СБП</label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Оформить заказ</button>
  </form>
</div>

@endsection