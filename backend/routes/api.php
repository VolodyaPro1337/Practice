<?php

use App\Http\Controllers\Api\AutomationOptionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ConfigurationController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/profiles/{profile}', [ProfileController::class, 'show']);
Route::post('/profiles', [ProfileController::class, 'store']);
Route::put('/profiles/{profile}', [ProfileController::class, 'update']);
Route::delete('/profiles/{profile}', [ProfileController::class, 'destroy']);

Route::get('/materials', [MaterialController::class, 'index']);
Route::get('/materials/{material}', [MaterialController::class, 'show']);
Route::post('/materials', [MaterialController::class, 'store']);
Route::put('/materials/{material}', [MaterialController::class, 'update']);
Route::delete('/materials/{material}', [MaterialController::class, 'destroy']);

Route::get('/automation-options', [AutomationOptionController::class, 'index']);
Route::get('/automation-options/{automationOption}', [AutomationOptionController::class, 'show']);
Route::post('/automation-options', [AutomationOptionController::class, 'store']);
Route::put('/automation-options/{automationOption}', [AutomationOptionController::class, 'update']);
Route::delete('/automation-options/{automationOption}', [AutomationOptionController::class, 'destroy']);

Route::get('/configurations', [ConfigurationController::class, 'index']);
Route::get('/configurations/{configuration}', [ConfigurationController::class, 'show']);
Route::post('/configurations', [ConfigurationController::class, 'store']);
Route::put('/configurations/{configuration}', [ConfigurationController::class, 'update']);
Route::delete('/configurations/{configuration}', [ConfigurationController::class, 'destroy']);

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{order}', [OrderController::class, 'update']);
Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
