<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard.index')->name('dashboard.index');
    Route::livewire('/customer', 'pages::customer.index')->name('customer.index');
    Route::livewire('/order', 'pages::order.index')->name('order.index');
    Route::livewire('/preparation', 'pages::preparation.index')->name('preparation.index');
    Route::livewire('/delivery', 'pages::delivery.index')->name('delivery.index');
    Route::livewire('/historic', 'pages::historic.index')->name('historic.index');
});
