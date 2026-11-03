<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
use Validator;

class profileController extends Controller
{
  public function profile()
  {
    $user = Auth::user();
    if (!$user){
      return redirect()->route('login');
    }
    return view('profile.userInfo', [
      'user'=>$user,
    ]);
  }


  public function editName(Request $request)
  {
    $user = Auth::user();
    if (!$user){
      return redirect()->route('login');
    }
    $validator = validator()->make($request->all(), [
      'firstName' => 'required|string',
      'lastName' => 'required|string'
    ]);

    if ($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput();
    }
    else {
      $user->firstName = $request->firstName;
      $user->lastName = $request->lastName;
  
      $user->save();
      return redirect()->back()->with('success', 'Вы успешно поменяли имя');
    }
  }


  public function editPhone(Request $request)
  {
    $user = Auth::user();
    if (!$user){
      return redirect()->route('login');
    }
    $validator = Validator::make($request->all(), [
      'phone'=> 'required',
    ]);

    if ($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput();
    } else {
      $user->phone = $request->phone;
      $user->save();
      return redirect()->back()->with('success', 'Вы успешно изменили номер телефона');
    }

  }


  public function orders()
  {
    $user = Auth::user();
    if (!$user){
      return redirect()->route('login');
    }
    $orders = Order::where('id_user', $user->id)->where('status', 'Новый заказ')->orWhere('status', 'В работе')->get();
    
    return view('profile.orders', [
      'orders'=>$orders,
    ]);
  }
  public function ordersHistory()
  {
    $user = Auth::user();
    if (!$user){
      return redirect()->route('login');
    }
    $orders = Order::where('id_user', $user->id)->where('status', 'Доставлен')->orWhere('status', 'Отменен')->get();
    
    return view('profile.ordersHistory', [
      'orders'=>$orders,
    ]);
  }

}
