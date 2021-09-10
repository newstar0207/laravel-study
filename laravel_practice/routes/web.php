<?php

use App\Http\Controllers\CarsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Cache;
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

Route::get('/test', function () {
    return ('test');
})->name('test');

Route::get('/about', function () {
    return redirect()->route('test');
});





Route::resource('/cars', CarsController::class);

// Route::get('/', [PostsController::class, 'index']);


// Route::get('/', [PagesController::class, 'index']);
Route::get('/about', [PagesController::class, 'about']);


Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/products/about', [ProductsController::class, 'about']);

// Pattern is integer
// Route::get('/products/{id}', [ProductsController::class, 'show'])->where('id', '[0-9]+'); // [0-9]+ 숫자만 됨

// add String, integer Pattern
Route::get('/products/{name}/{id}', [ProductsController::class, 'show'])->where([
    'name' => '[a-zA-Z]+',
    'id' => '[0-9]+'
]); // [0-9]+ 숫자만 됨
