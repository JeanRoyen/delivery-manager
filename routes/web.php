<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'language'])->group(function () {
    Route::livewire('/', 'pages::dashboard.index')->name('dashboard.index');
    Route::livewire('/customer', 'pages::customer.index')->name('customer.index');
    Route::livewire('/customer/create', 'pages::customer.create')->name('customer.create');
    Route::livewire('/product', 'pages::product.index')->name('product.index');
    Route::livewire('/product/create', 'pages::product.create')->name('product.create');

    Route::prefix('orders')->group(function () {
        Route::livewire('/create', 'pages::orders.create')->name('orders.create');
        Route::livewire('/delivered', 'pages::orders.delivered.index')->name('delivered.index');
        Route::livewire('/delivering', 'pages::orders.delivering.index')->name('delivering.index');
        Route::livewire('/pending', 'pages::orders.pending.index')->name('pending.index');
        Route::livewire('/preparing', 'pages::orders.preparing.index')->name('preparing.index');
        Route::livewire('/{order}', 'pages::orders.show')->name('orders.show');
    });
});
