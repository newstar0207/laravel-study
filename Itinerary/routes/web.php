<?php

use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\ChatRoomController;
use App\Http\Controllers\API\UserStateController;
use App\Http\Controllers\roomController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('chatroom', ChatRoomController::class)->only([
    'update', 'store', 'destroy', 'index'
]);

Route::get('/room', [roomController::class, 'index'])->name('room');
// Route::get('/chat/')
// Route::get('/chat/{$id}', [ChatController::class, 'index']);

Route::resource('chatroom.chat', ChatController::class)->only([
    'index', 'store'
]);

Route::middleware(['auth:sanctum', 'verified'])->put('/user/{id}/{state}/{roomId}', UserStateController::class);
