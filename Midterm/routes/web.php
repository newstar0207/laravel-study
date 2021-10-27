<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\PostController;
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

Route::resource('post', PostController::class)->only([
    'index', 'store', 'destroy', 'show', 'update'
]);
Route::resource('post.chat', ChatController::class)->shallow()->only([
    'store', 'destroy', 'update'
]);

// Route::prefix('post')->group(function () {
//     Route::get('/', [PostController::class, 'index'])->name('post.index');
//     Route::post('/', [PostController::class, 'store'])->name('post.store');
//     Route::post('/{post}', [PostController::class, 'show'])->name('post.store');
// });
