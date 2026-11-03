<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    function CategoryProduct()
    {
      return $this->hasMany(Product::class, 'id_category');
    }
}
