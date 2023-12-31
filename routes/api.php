<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/verify', [AuthController::class, 'verifyUser'])->name('verify');
Route::post('/resend', [AuthController::class, 'resend'])->name('resend');
Route::get('/user', function (Request $request) {return $request->user();})->middleware('auth:sanctum');
Route::post('/user',[UserController::class,'update'])->middleware('auth:sanctum');
Route::post('/reset-password',[UserController::class,'updatePassword'])->middleware('auth:sanctum');


Route::get('/user/products',[ProductController::class,'userProducts'])->middleware('auth:sanctum');
Route::post('/products/user/assign',[ProductController::class,'assign']);
Route::delete('/products/user/remove',[ProductController::class,'remove']);
Route::put('/products/{id}',[ProductController::class,'update'])->middleware('auth:sanctum');
Route::resource('products',ProductController::class)->middleware('auth:sanctum');
