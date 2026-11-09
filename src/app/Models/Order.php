<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $guarded = [];

  public function orderUser()
  {
    return $this->belongsTo(User::class, 'id_user');
  }

  public function items()
  {
    return $this->hasMany(order_item::class, 'id_order');
  }

}
