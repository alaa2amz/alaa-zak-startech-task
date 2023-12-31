<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductAjaxController;
use App\Http\Controllers\UserAjaxController;
use App\Http\Controllers\AssignAjaxController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
    Route::get('/myproducts', [ProductAjaxController::class, 'myindex'])->name('myproducts');
});

##### ONLY ADMIN GROUP######
Route::middleware('auth','is-admin')->group(function () {
Route::resource('assign', AssignAjaxController::class);
Route::resource('products', ProductAjaxController::class);
Route::resource('users', UserAjaxController::class);
});

require __DIR__.'/auth.php';
