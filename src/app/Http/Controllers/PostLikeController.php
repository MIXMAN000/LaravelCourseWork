<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostLikeController extends Controller
{
  public function toggle(Post $post)
  {
    $result = auth()->user()->likedPosts()->toggle($post->id);

    if (!empty($result['attached'])) {
      $post->increment('likes');
    } else {
      $post->decrement('likes');
    }

    return back();
  }
}
