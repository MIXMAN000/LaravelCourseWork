<?php

use App\Http\Controllers\indexController;
use App\Http\Controllers\catalogController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\storeController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', [indexController::class, 'index'])->name('index');

Route::get('/catalog', [CatalogController::class, 'catalog'])->name('catalog');

Route::get('/catalog/category', [catalogController::class, 'category'])->name('catalogCategory');
Route::get('/catalog/sort', [catalogController::class, 'catalogSort'])->name('catalogSort');

Route::get('/card/{id}', [catalogController::class, 'productCard'])->name('productCard');

Route::get('/catalog/search', [catalogController::class, 'search'])->name('search');



Route::get('/contact', [indexController::class, 'contact'])->name('contact');

Route::get('/deliveryInfo', [indexController::class, 'deliveryInfo'])->name('deliveryInfo');

Route::get('/news', [indexController::class, 'news'])->name('news');

Route::post('/posts/{post}/like', [PostLikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('posts.like');


Route::get('/basket', [indexController::class, 'basket'])->name('basket');
Route::post('/addToBasket', [storeController::class, 'addToBasket'])->name('addToBasket');
Route::post('/deleteBasket', [storeController::class, 'deleteBasket'])->name('deleteBasket');
Route::post('/plusCountBasket', [storeController::class, 'plusCountBasket'])->name('plusCountBasket');
Route::post('/minusCountBasket', [storeController::class, 'minusCountBasket'])->name('minusCountBasket');


Route::get('/basket/checkout', [indexController::class, 'checkout'])->name('checkout');
Route::post('/storeCheckout', [storeController::class, 'storeCheckout'])->name('storeCheckuot');



Route::get('/profile', [profileController::class, 'profile'])->name('profile');



Route::post('profile/editName', [profileController::class, 'editName'])->name('editName');
Route::post('profile/editPhone', [profileController::class, 'editPhone'])->name('editPhone');


Route::get('/profile/orders', [profileController::class, 'orders'])->name('orders');
Route::get('/profile/ordersHistory', [profileController::class, 'ordersHistory'])->name('ordersHistory');




Route::get('/login', [indexController::class, 'login'])->name('login');
Route::get('/signin', [indexController::class, 'signin'])->name('signin');

Route::get('/logout', [indexController::class, 'logout'])->name('logout');


Route::post('login', [storeController::class, 'storeLogin'])->name('storeLogin');
Route::post('signin', [storeController::class, 'storeSignin'])->name('storeSignin');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');

    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');

    Route::get('/posts', [AdminController::class, 'posts'])->name('posts.index');
    Route::get('/posts/create', [AdminController::class, 'createPost'])->name('posts.create');
    Route::post('/posts', [AdminController::class, 'storePost'])->name('posts.store');
    Route::get('/posts/{post}/edit', [AdminController::class, 'editPost'])->name('posts.edit');
    Route::put('/posts/{post}', [AdminController::class, 'updatePost'])->name('posts.update');
});


