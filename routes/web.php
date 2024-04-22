<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class,'index'])->name('home');
Route::get('/shopdetail', function () {
    return view('/clients/shop-detail');
});

Route::name('users.')->group(function () {
    Route::get('/shop', function () {
        return view('clients.shop');
    });
    Route::get('/cart', function () {
        return view('clients.cart');
    });
    Route::get('/contact', function () {
        return view('clients.contact');
    });
    Route::get('/product/{id}',[ProductController::class, 'showDetail']);
    
    Route::get('/checkout', function () {
        return view('clients.chackout');
    });
});


Route::prefix('/admin')->group(function () {

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::view('/test', 'welcome');

require __DIR__.'/auth.php';

