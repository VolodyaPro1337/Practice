<?php

use App\Http\Controllers\Admin\AutomationOptionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConfigurationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('profiles', ProfileController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('automation-options', AutomationOptionController::class);
    Route::resource('configurations', ConfigurationController::class)->only(['index', 'show', 'destroy']);
    Route::resource('orders', OrderController::class)->except(['create', 'store']);
});
