<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\About_us;
use App\Models\Product;
use App\Models\Review;
use App\Models\Category;

class catalogController extends Controller
{
  function catalog()
  {
    $categories = Category::all();
    $products = Product::all();
    
    return view('catalog', [
      'categories' => $categories,
      'products' => $products,
      'category_id' => 0,
    ]);
  }

  function catalogSort(Request $request){

    if (!empty($request->sort))
      {
        $sort = $request->sort;
        if ($sort == 'lowestPrice')
          {
            $products = Product::orderBy('price')->get();
          }
        else if ($sort == 'highestPrice')
          {
            $products = Product::orderByDesc('price')->get();
          }
        else 
          {
            $products = Product::all();
          }
      }
      else 
        {
          $products = Product::all();
        }

    $categories = Category::all();
    
    return view('catalog', [
      'categories' => $categories,
      'products' => $products,
      'category_id' => 0,
    ]);
  }


  function category(Request $request)
  {
    if (!empty($request->input('category'))){
      $category_id = $request->input('category');
    }

    if ($category_id == 'news')
      {
        $products = Product::where('news', 1)->get();
      }
    else if ($category_id == 'action')
      {
        $products = Product::where('action', 1)->get();
      }
    else 
      {
        $products = Product::where('id_category', $category_id)->get();
      }

    $categories = Category::all();

    return view('catalog', [
      'categories' => $categories,
      'products' => $products,
      'category_id' => $category_id,
    ]);
  }
  public function search()
  {
    $categories = Category::all();
    $products = Product::
    return view('catalog', [
      'categories' => $categories,
      'products' => $products,
      'category_id' => 0,
    ]);
  }

  function productCard($idProduct)
  {
    $product = Product::where('id_product', $idProduct)->first();
    $inBasket = false;
    if (Auth::check())
      {
        $user = Auth::user();
        $inBasket = $user->userBasket()->where('id_product', $idProduct)->exists();
      }
    else 
      {
        $user = false;
      }

    return view('productCard', [
      'product' => $product,
      'user' => $user,
      'inBasket' => $inBasket,
    ]);
  }
}
