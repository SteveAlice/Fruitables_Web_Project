

<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function(){
        Route::view('/login','back.pages.admin.auth.login')->name('login');
        Route::post('/login_handler', [AdminController::class,'loginHanler'])->name('login_handler');
    });

    Route::middleware(['auth:admin'])->group(function() {
        Route::view('/home', 'back.pages.admin.home')->name('home');
        Route::post('/logout_handler',[AdminController::class,'logoutHanler'])->name('logout_handler');
    });

});

// Route::get('/admin', function(){
//     return "Hell Admin!!";
// });


