<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Route::get('/', [ProductController::class, 'indexHome'])->name('home');

Route::name('user.')->group(function () {
    Route::get('/shop', function () {
        return view('clients.shop');
    });

    Route::get('/contact', function () {
        return view('clients.contact');
    });
    Route::get('/product/{id}', [ProductController::class, 'show']);

    Route::middleware('auth')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/create/{id}', [CartController::class, 'create'])->name('cart.create');
        // Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::resource('carts', CategoryController::class)->only('update');
        Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    });


    Route::get('/noticlr', [OrderController::class, 'notify'])->name('noti.clear');
    Route::get('/notiemail', [ProductController::class, 'setEmailNoti'])->name('email.noti');

    Route::post('/reviews-store', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/checkout', function () {
        return view('clients.chackout');
    });
});

Route::prefix('/admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::view('/', 'admin.index')->name('home');
    
    Route::resource('categories', CategoryController::class)->except(['show', 'edit']);

    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products-create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products-store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products-edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products-update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products-destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::resource('orders', OrderController::class)->only(['index', 'update']);
    Route::get('/order-detail/{id}', [OrderController::class, 'show'])->name('orders.show')->middleware('order')->withoutMiddleware('admin');
});


Route::get('/search', [ProductController::class, 'search']);




Route::get('/dashboard', function () {
    $carts = \App\Models\Cart::all();
    return view('dashboard', compact('carts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});
Route::view('/err', '/clients/404')->name('404');

require __DIR__ . '/auth.php';

