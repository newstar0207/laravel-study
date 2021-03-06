<?php

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

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('welcome');
})->name('comments');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () { // dashboard 사용시 auth:sanctum, verified 미들웨어를 사용함
    return view('dashboard');
})->name('dashboard');

Route::get('/counter', function () {
    return view('livewire.home');
});

Route::post('/register', function () {
    return view('auth.register');
});
