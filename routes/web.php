<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerProducts;
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
Route::get('cart/add/{id}', [CartController::class,'addToCart'])->name('cart.add');
Route::get('product/show/{id}', [ProductController::class, 'show'])->name('product.show');

Route::resource('/product',ProductController::class);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});
Route::get('/cart', function () {
    return view('cart');
});
Route::get('/contact',function()
{
    return view('contact');
});
Route::get('/checkout',function()
{
    return view('chackout');
});
Route::get('/error',function()
{
    return view('404');
});
Route::get('/shop',function()
{
    return view('shop');
});
Route::get('/shopdetail',function()
{
    return view('shop-detail');
});
Route::get('/testimonial',function()
{
    return view('testimonial');
});





