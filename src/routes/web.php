<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(['prefix' => 'orders'], function(){
    Route::get('/', [OrderController::class, 'index'])->name('orders');
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
});


Route::post('/ration/store', [RationController::class, 'store'])->name('rations.store');


// Route::resource('orders', OrderController::class);





require __DIR__.'/auth.php';