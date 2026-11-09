<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\About_us;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Post;


class indexController extends Controller
{
  function index()
  {
    $about_us = About_us::value('text');

    $productsActions = Product::where('action', '=', '1')->get();

    $productsNews = Product::where('news', '=', '1')->get();

    $reviews = Review::all();

    return view('index', ['about_us' => $about_us,
                         'productsActions' => $productsActions, 
                         'productsNews' => $productsNews,
                         'reviews' => $reviews]);
  }

  function contact()
  {
    return view('contact', [
      '' => '',
    ]);
  }

  public function deliveryInfo()
  {
    return view('deliveryInfo');
  }

  public function news()
  {
    $posts = Post::query()
    ->when(auth()->check(), fn ($q) => $q->withExists([
        'likedBy as liked' => fn ($q) => $q->where('user_id', auth()->id()),
    ]))
    ->latest()
    ->get();

    return view('news', [
      'posts' => $posts,
    ]);
  }


  public function basket() 
  {
    
    $user = Auth::user();
    if (!$user){
      return redirect()->route('login');
    }
    $count_products = $user->userBasket()->count();
    $baskets = $user->userBasket()->with('basketProduct')->get();
    $basket_price = $baskets->sum(function($item) {
      return $item->count * ($item->basketProduct?->price ?? 0);
    });
    $totalCountProducts = $baskets->sum('count');
    $hasUnavailableItems = $baskets->contains(fn ($item) =>
      !$item->basketProduct || $item->basketProduct->inventory < $item->count
    );

    return view('basket', [
      'count_products' => $count_products,
      'baskets' => $baskets,
      'basket_price' => $basket_price,
      'totalCountProducts' => $totalCountProducts,
      'hasUnavailableItems' => $hasUnavailableItems,
    ]);
  }

  public function checkout()
  {
    $user = Auth::user();
    if (!$user){
      return redirect()->route('login');
    }
    $baskets = $user->userBasket()->with('basketProduct')->get();

    if ($baskets->contains(fn ($item) =>
      !$item->basketProduct || $item->basketProduct->inventory < $item->count
    )) {
      return redirect()->route('basket')->withErrors('В корзине есть закончившиеся товары или количество превышает остаток. Исправьте корзину перед оформлением.');
    }
    $basket_price = $baskets->sum(function($item) {
      return $item->count * $item->basketProduct->price;
    });

    $totalCountProducts = $baskets->sum('count');
    return view('checkout', [
      'user' => $user,
      'baskets' => $baskets,
      'basket_price' => $basket_price,
      'totalCountProducts' => $totalCountProducts,
    ]);
  }


  public function login()
  {
    return view('login');
  }

  public function signin()
  {
    return view('signin');
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->route('index');
  }
}
