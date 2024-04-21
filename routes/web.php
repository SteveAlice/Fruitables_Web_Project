<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('product/show/{id}', [ProductController::class, 'show'])->name('product.show');


Route::get('/', [ProductController::class,'index'])->name('home');
Route::get('/shopdetail', function () {
    return view('/clients/shop-detail');
});

Route::name('users.')->group(function () {
    Route::get('/shop', function () {
        return view('/clients/shop');
    });
    Route::get('/cart', function () {
        return view('/clients/cart');
    });
    Route::get('/contact', function () {
        return view('/clients/contact');
    });
    Route::get('/product/{id}',[ProductController::class, 'showDetail']);
    
    Route::get('/checkout', function () {
        return view('/clients/chackout');
    });
});


Route::prefix('/admin')->group(function () {

});







