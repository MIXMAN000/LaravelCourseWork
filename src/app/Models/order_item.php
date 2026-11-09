<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class order_item extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
      'id',
      'id_order',
      'id_product', 
      'count',
    ];
    public $timestamps = false;

    public function order()
    {
      return $this->belongsTo(Order::class, 'id_order');
    }

    public function product()
    {
      return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
