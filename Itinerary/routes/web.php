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

Route::get('home', function () {
    return Inertia::render('Container');
});

Route::prefix('room')->group(function () {
    Route::get('/', [RoomController::class, 'index'])->name('room.index');
    Route::post('/', [Roomcontroller::class, 'store'])->name('room.store');
    Route::get('/{roomId}', [RoomController::class, 'show'])->name('room.show');
    Route::patch('/{roomId}', [RoomController::class], 'update')->name('room.update');
});
