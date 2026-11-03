<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    function ReviewUser()
    {
      return $this->hasOne(User::class, 'id');
    }
}
