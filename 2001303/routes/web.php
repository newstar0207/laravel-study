<?php

use App\Http\Controllers\DefaultController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TakeController;
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


Route::resource('subject', SubjectController::class)->only([
    'index', 'store', 'show', 'destroy', 'update'
]);
Route::resource('subject.take', TakeController::class)->only([
    'store', 'destroy', 'index'
]);

Route::get('user/{user_id}/take', [DefaultController::class, 'userSubject']);
