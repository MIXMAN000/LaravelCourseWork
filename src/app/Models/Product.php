<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    function ProductCategory()
    {
      return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function productBasket()
    {
      return $this->hasMany(Basket::class, 'id_product');
    }
}
