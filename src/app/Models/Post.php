<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $fillable = [
    'name', 
    'text',
    'likes',
    'img',
  ];

  public function likedBy()
  {
      return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
  }

}
