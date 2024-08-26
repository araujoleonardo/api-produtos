<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::get('/user', function (Request $request) {
    return [
        'request' => $request
    ];
});

Route::post('/register',    [AuthController::class, 'register']);
Route::post('/login',       [AuthController::class, 'login']);
Route::get('/auth',         [AuthController::class, 'auth']);
Route::post('/logout',      [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    //Category
    Route::get('/category',                 [CategoryController::class, 'index'])->name('category.index');
    Route::get('/list-categories',          [CategoryController::class, 'list'])->name('category.list');
    Route::post('/category-create',         [CategoryController::class, 'store'])->name('category.create');
    Route::post('/category-update',         [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category-delete/{id}',  [CategoryController::class, 'destroy'])->name('category.delete');

    //Product
    Route::get('/product',                 [ProductController::class, 'index'])->name('product.index');
    Route::post('/product-create',         [ProductController::class, 'store'])->name('product.create');
    Route::post('/product-update',         [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product-delete/{id}',  [ProductController::class, 'destroy'])->name('product.delete');
});


