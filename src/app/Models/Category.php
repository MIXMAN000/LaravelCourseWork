<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id_category';
    public $timestamps = false;
    protected $guarded = [];

    function CategoryProduct()
    {
      return $this->hasMany(Product::class, 'id_category');
    }
}
