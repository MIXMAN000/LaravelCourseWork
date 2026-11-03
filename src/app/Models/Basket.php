<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Basket extends Model
{
    public $timestamps = false;
    protected $table = 'basket';
    protected $primaryKey = 'basket_id';

    protected $fillable = [
      'id_product',
      'id_user',
      'count',
    ];

    public function basketUser()
    {
      return $this->belongsTo(User::class, 'id_user');
    }

    public function basketProduct()
    {
      return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
