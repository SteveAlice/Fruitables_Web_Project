<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ControllerProducts;



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

Route::get('/', function () {
    return view('welcome');
});
Route::view('/example-auth', 'example-auth');
Route::view('/example-page', 'example-page');
Route::view('/example-frontend', 'example-frontend');



// Route::get('cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
// Route::get('product/show/{id}', [ProductController::class, 'show'])->name('product.show');

// Route::resource('/product', ProductController::class);

// Route::get('/', function () {
//     return view('/clients/home');
// });

// Route::name('users.')->group(function () {
//     Route::get('/shop', function () {
//         return view('/clients/shop');
//     });
//     Route::get('/cart', function () {
//         return view('/clients/cart');
//     });
//     Route::get('/contact', function () {
//         return view('/clients/contact');
//     });
//     Route::get('/shop-detail', function () {
//         return view('/clients/shop-detail');
//     });
//     Route::get('/checkout', function () {
//         return view('/clients/checkout');
//     });
// });
