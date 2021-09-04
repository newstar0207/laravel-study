<?php

use App\Http\Controllers\ProductsController;
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

Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/products/about', [ProductsController::class, 'about']);

// Pattern is integer
// Route::get('/products/{id}', [ProductsController::class, 'show'])->where('id', '[0-9]+'); // [0-9]+ 숫자만 됨

// add String, integer Pattern
Route::get('/products/{name}/{id}', [ProductsController::class, 'show'])->where([
    'name' => '[a-zA-Z]+',
    'id' => '[0-9]+'
]); // [0-9]+ 숫자만 됨
