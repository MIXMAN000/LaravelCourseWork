<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Hash;
use Validator;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\order_item;

class storeController extends Controller
{
    public function storeLogin(Request $request)
    {
      $request->validate([
        'email'=>'required|email',
        'password'=>'required|string',
      ]);

      if (Auth::attempt([
        'email'=>$request->email,
        'password'=>$request->password,
      ]))
      {
        $user = Auth::user();
        
        if ($user->role == 'admin'){
          return redirect()->route('index');
        }
        else{
          return redirect()->route('catalog');
        }
      };

      return redirect()->back()->withErrors('Неверный логин или пароль');
    }

    public function storeSignin(Request $request)
    {
      $validator = validator::make($request->all(), [
        'firstname' => 'required',
        'lastname'=>'required',
        'phone'=>'required',
        'email'=>'required',
        'password'=>'required',
      ]);

      if ($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }

      User::create([
        'password' => Hash::make($request->password)
      ]+$request->all());

      return redirect()->back()->with('success', 'Вы успешно создали аккаунт');

    }

    public function addToBasket(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'product_count' => 'required|min:1',
        'id_product' => 'required',
      ]);

      if ($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }
      else {
        $user = Auth::user();
        $basket = new Basket();
        $basket->id_product = $request->id_product;
        $basket->id_user = $user->id;
        $basket->count = $request->product_count;
        $basket->save();
        return redirect()->back()->with('success', 'Вы успешно добавили товар в корзину');
      }
    }
    public function deleteBasket(Request $request)
    {
      $basket = Basket::find($request->basket_id);
      $basket->delete();
      return redirect()->back();
    }

    public function plusCountBasket(Request $request)
    {
      $basket = Basket::findOrFail($request->basket_id);
      $basket->count = $basket->count + 1;
      $basket->save();
      return redirect()->back();
    }
    public function minusCountBasket(Request $request)
    {
      $basket = Basket::findOrFail($request->basket_id);
      $basket->count = $basket->count - 1;
      if ($basket->count == 0)
        {
          $basket->delete();
          return redirect()->back();
        }
      $basket->save();
      return redirect()->back();
    }

    public function storeCheckout(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'payment' => 'required',
        'sum' => 'required',
      ]);

      if ($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }
      
      $user = Auth::user();
      $basketItems = $user->userBasket()->get();

      if ($basketItems->isEmpty()){
        return redirect()->back()->withErrors('Корзина пуста');
      }

      DB::transaction(function () use ($user, $request, $basketItems){
        $order = new Order;
        $order->id_user = $user->id;
        $order->payment_type = $request->payment;
        $order->sum = $request->sum;
        $order->save();

        foreach ($basketItems as $item) {
          order_item::create([
            'id_order' => $order->id,
            'id_product' => $item->id_product,
            'count' => $item->count,
          ]);
        }

        $user->userBasket()->delete();

      });

      return redirect()->route('orders')->with('success', 'Заказ успешно оформлен');
    }

    // public function search(Request $request)
    // {

    //   $products
    //   return view('catalog', [
    //     '' => '',
    //   ]);
    // }
}
