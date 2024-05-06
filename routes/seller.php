<?php

use App\Http\Controllers\Seller\SellerController;
use Illuminate\Support\Facades\Route;

Route::prefix('seller')->name('seller.')->group(function(){

    Route::middleware(['guest:seller','PreventBackHistory'])->group(function(){
        Route::controller(SellerController::class)->group(function(){
            Route::get('/login','login')->name('login');
            Route::post('/login-handler','loginHandler')->name('login-handler');
            Route::get('/register','register')->name('register');
            Route::post('/create','createSeller')->name('create');
            Route::get('/account/verify/{token}','verifyAccount')->name('verify');
            Route::get('/register-success','registerSuccess')->name('register-success');
            Route::get('/forgot-password','forgotPassword')->name('forgot-password');
            Route::post('/send-password-reset-link','sendPasswordResetLink')->name('send-password-reset-link');
            Route::get('/password/reset/{token}','showResetForm')->name('reset-password');
            
            Route::post('/reset-password-handler','resetPasswordHandler')->name('reset-password-handler');
        });
    });

    Route::middleware(['auth:seller','PreventBackHistory'])->group(function(){
        Route::controller(SellerController::class)->group(function(){
            Route::get('/','home')->name('home');
            Route::post('/logout','logoutHandler')->name('logout');
        });
    });

});

