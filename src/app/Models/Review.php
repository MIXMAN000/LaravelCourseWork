<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $primaryKey = 'id_review';
    public $timestamps = false;

    function ReviewUser()
    {
      return $this->belongsTo(User::class, 'id_user');
    }
}
