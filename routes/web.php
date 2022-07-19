<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=> ['web','auth']],function()
{
    Route::get('/users',[UserController::class,'index'])->name('users');
    Route::get('/users/{user_id}/edit',[UserController::class,'edit']);
    Route::post('/users/store',[UserController::class,'store']);
    Route::put('/users/{user_id}',[UserController::class,'update']);
    Route::delete('/users/delete/{user_id}',[UserController::class,'destroy']);


    Route::get('/products',[ProductController::class,'index'])->name('products');
    Route::get('/products/{product_id}/edit',[ProductController::class,'edit']);
    Route::post('/products/store',[ProductController::class,'store']);
    Route::put('/products/{product_id}',[ProductController::class,'update']);
    Route::delete('/products/delete/{product_id}',[ProductController::class,'destroy']);

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::post('/logout',[LoginController::class,'logout'])->name('logout');
});

    Route::group(['middleware'=>'guest'],function(){
        
        Route::get('/login',[LoginController::class,'index'])->name('login');
        Route::post('/login',[LoginController::class,'authenticate'])->name('dologin');
    });
