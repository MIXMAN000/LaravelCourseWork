@extends('blades.profileTemp')
@section('profile')
  <h3 class="display-6">История заказов</h3>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Номер заказа</th>
        <th>Способ оплаты</th>
        <th>Статус</th>
        <th>Причина отмены</th>
        <th>Товары (шт)</th>
        <th>Дата оформления</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($orders as $order)
        <tr>
          <td>{{$order->id}}</td>
          <td>{{$order->payment_type}}</td>
          <td class="{{ $order->status === 'Доставлен' ? 'bg-success' : 'bg-danger'}}">{{$order->status}}</td>
          <td>{{ $order->cancellation_reason }}</td>
          <td><button class="btn btn-primary" id="orderItems{{ $order->id }}" data-bs-toggle="modal" data-bs-target="#orderItems{{ $order->id }}">{{ $order->items()->count() }}</button></td>
          <td>{{$order->created_at}}</td>
        </tr>
<div class="modal fade" id="orderItems{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">В заказе №{{ $order->id }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach ($order->items as $item)
          <div class="d-flex flex-row justify-content-between align-items-center">
            <p>{{ $item->product->name_product }}</p>
            <p>{{ $item->count }}</p>
          </div>
          <hr class="mt-0">
        @endforeach
        <p>Итого: {{ $order->sum }}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

      @endforeach
    </tbody>
  </table>


@endsection
