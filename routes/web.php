<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';



Route::middleware(['auth'])->group(function () {
    Route::get('/products', \App\Livewire\Products::class)->name('products');

    Route::get('/orders', \App\Livewire\UserOrders::class)->name('orders');

    // Admin routes
    Route::prefix('admin')
//        ->middleware('can:admin')
        ->group(function () {
        Route::get('/orders', \App\Livewire\AdminOrders::class)->name('admin.orders');
        Route::get('/products', \App\Livewire\AdminProducts::class)->name('admin.products');
    });

//    Route::get('/admin/products', \App\Http\Livewire\AdminProductCrud::class)->name('admin.products');
});
