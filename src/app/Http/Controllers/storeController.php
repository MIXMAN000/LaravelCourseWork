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
use App\Models\Product;
use Illuminate\Validation\ValidationException;

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
          return redirect()->route('admin.dashboard');
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
        'product_count' => 'required|integer|min:1',
        'id_product' => 'required|exists:products,id_product',
      ]);

      if ($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }
      else {
        $user = Auth::user();
        if (!$user) {
          return redirect()->route('login');
        }

        $product = Product::findOrFail($request->id_product);
        $basket = $user->userBasket()->where('id_product', $product->id_product)->first();
        $requestedCount = (int) $request->product_count + ($basket?->count ?? 0);

        if ($product->inventory <= 0) {
          return redirect()->back()->withErrors('Товар закончился и не может быть добавлен в корзину.');
        }

        if ($requestedCount > $product->inventory) {
          return redirect()->back()->withErrors('Нельзя добавить больше товара, чем есть в наличии. Доступно: '.$product->inventory.' шт.');
        }

        if ($basket) {
          $basket->count = $requestedCount;
          $basket->save();
        } else {
          Basket::create([
            'id_product' => $product->id_product,
            'id_user' => $user->id,
            'count' => (int) $request->product_count,
          ]);
        }

        return redirect()->back()->with('success', 'Вы успешно добавили товар в корзину');
      }
    }
    public function deleteBasket(Request $request)
    {
      $user = Auth::user();
      if (!$user) {
        return redirect()->route('login');
      }

      $basket = $user->userBasket()->findOrFail($request->basket_id);
      $basket->delete();
      return redirect()->back();
    }

    public function plusCountBasket(Request $request)
    {
      $user = Auth::user();
      if (!$user) {
        return redirect()->route('login');
      }

      $basket = $user->userBasket()->with('basketProduct')->findOrFail($request->basket_id);

      if (!$basket->basketProduct || $basket->basketProduct->inventory <= $basket->count) {
        return redirect()->back()->withErrors(
          !$basket->basketProduct || $basket->basketProduct->inventory <= 0
            ? 'Товар закончился.'
            : 'В наличии только '.$basket->basketProduct->inventory.' шт.'
        );
      }

      $basket->count = $basket->count + 1;
      $basket->save();
      return redirect()->back();
    }
    public function minusCountBasket(Request $request)
    {
      $user = Auth::user();
      if (!$user) {
        return redirect()->route('login');
      }

      $basket = $user->userBasket()->findOrFail($request->basket_id);
      if ($basket->count <= 1)
        {
          $basket->delete();
          return redirect()->back();
        }
      $basket->count = $basket->count - 1;
      $basket->save();
      return redirect()->back();
    }

    public function storeCheckout(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'payment' => 'required|in:Банковской картой,СБП',
      ]);

      if ($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }
      
      $user = Auth::user();
      if (!$user) {
        return redirect()->route('login');
      }

      $basketItems = $user->userBasket()->get();

      if ($basketItems->isEmpty()){
        return redirect()->back()->withErrors('Корзина пуста');
      }

      DB::transaction(function () use ($user, $request){
        $basketItems = $user->userBasket()->lockForUpdate()->get();

        if ($basketItems->isEmpty()) {
          throw ValidationException::withMessages(['basket' => 'Корзина пуста.']);
        }

        $groupedItems = $basketItems->groupBy('id_product');
        $products = Product::whereIn('id_product', $groupedItems->keys())
          ->lockForUpdate()
          ->get()
          ->keyBy('id_product');
        $orderSum = 0;

        foreach ($groupedItems as $productId => $items) {
          $product = $products->get($productId);
          $requestedCount = $items->sum('count');

          if (!$product || $product->inventory <= 0) {
            throw ValidationException::withMessages([
              'stock' => 'Товар «'.($product?->name_product ?? 'Неизвестный товар').'» закончился. Удалите его из корзины.',
            ]);
          }

          if ($requestedCount > $product->inventory) {
            throw ValidationException::withMessages([
              'stock' => 'Для товара «'.$product->name_product.'» доступно только '.$product->inventory.' шт.',
            ]);
          }

          $orderSum += $product->price * $requestedCount;
        }

        $order = new Order;
        $order->id_user = $user->id;
        $order->payment_type = $request->payment;
        $order->sum = $orderSum;
        $order->save();

        foreach ($groupedItems as $productId => $items) {
          $count = $items->sum('count');

          order_item::create([
            'id_order' => $order->id,
            'id_product' => $productId,
            'count' => $count,
          ]);

          $products->get($productId)->decrement('inventory', $count);
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
