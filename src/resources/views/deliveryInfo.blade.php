@extends('blades.template')
@section('title', 'Доставка и оплата')

@section('content')
  <div class="content m-4 p-4 bg-light">
    <h2>Оплата</h2>  
    <h3>Оплата происходит онлайн</h3>
    <p class="d-inline-flex gap-3">Банковской картой: <img src="/images/payments/mastercard.png" alt="mastercard" width="40"><img src="/images/payments/visa.png" alt="visa" width="40"><img src="/images/payments/MIR.jpg" alt="mir" width="40"></p><br>
    <p class="d-inline-flex gap-3">СБП: <img src="/images/payments/sbp.png" alt="sbp" width="40"></p>
  </div>
  <div class="content m-4 p-4 bg-light">
    <h2>Доставка</h2>
    <p>Мы доставляем наши игры по всей Росссии!</p>
    <p><b>Способы доставки:</b> Почта России, СДЭК</p>
    <p><b>Стоимость доставки:</b> Зависит от суммы заказа, веса и расстояния.</p>
    <p><b>Сроки формирования заказа:</b> Обрабатываем заказы и отправляем их в течение 1 рабочего дня после оплаты.</p>
    <p><b>Отслеживание заказа:</b> После отправки мы отправляем трек-номер для отслеживания заказа, он придет на вашу почту и будет отображаться в профиле.</p>
  </div>
  <div class="content m-4 p-4 bg-light">
    <h2>Возврат товара</h2>
    <p><b>Возврат товара:</b> Если товар не вскрыт, сохранен чек, сохранен товарный вид, то товар можно вернуть</p>
    <p><b>Возврат товара по браку:</b> если вы получили товар ненадлежащего качества, немедленно обратитесь в поддержку!</p>
  </div>
@endsection