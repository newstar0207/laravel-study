<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RoomController;
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

Route::prefix('room')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', [RoomController::class, 'index'])->name('room.index');
    Route::post('/', [Roomcontroller::class, 'store'])->name('room.store');
    Route::get('/find', [RoomController::class, 'find'])->name('room.find');
    Route::get('/{roomId}/chat', [RoomController::class, 'show'])->name('room.show');
    Route::post('/{roomId}/schedule', [RoomController::class, 'addSchedule'])->name('room.addSchdule');
    Route::put('/{roomId}/schedule/{scheduleId}', [RoomController::class, 'completeSchedule'])->name('room.completeSchdule');
    Route::delete('/{roomId}/schedule/{scheduleId}', [RoomController::class, 'deleteSchedule'])->name('room.deleteSchdule');
    Route::get('/{roomId}/schedule', [RoomController::class, 'getSchedule'])->name('room.getSchdule');
    Route::put('/{roomId}/cost', [RoomController::class, 'updateCost'])->name('room.updateCost');
    Route::patch('/{roomId}', [RoomController::class, 'update'])->name('room.update');
    Route::get('/{roomId}/update', [RoomController::class, 'getRoom'])->name('room.getRoom');
    Route::delete('/{id}', [RoomController::class, 'destroy'])->name('room.destroy');
    Route::delete('/{roomId}/user/{userId}', [RoomController::class, 'userBan'])->name('room.userBan');
    Route::get('/{roomId}/check/{userId}', [RoomController::class, 'checkUser'])->name('room.checkUser');
});

Route::get('/{roomId}/chat/{skip}', [ChatController::class, 'index'])->name('chat.index');
Route::post('/room/{roomId}/chat', [ChatController::class, 'store'])->name('chat.store');
Route::delete('/chat/{chatId}', [ChatController::class, 'destroy'])->name('chat.delete');
Route::post('room/chat/{chatId}', [ChatController::class, 'updateImageDesc'])->name('chat.updateImageDesc');
