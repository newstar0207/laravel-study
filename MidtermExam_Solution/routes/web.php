<?php

use App\Http\Controllers\ClassesController;
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


Route::prefix('classes')->group(function () {
    Route::get('registered', [ClassesController::class, 'index_cr'])->name('classes.index_cr'); // 수강신청한 교과목 리스트
    Route::get('/', [ClassesController::class, 'index'])->name('classes.index'); // 교과목 리스트
    Route::get('show/{classId}', [ClassesController::class, 'show'])->name('classes.show'); // 특정 교과목 상세보기
    Route::get('create', [ClassesController::class, 'create'])->name('classes.create'); // 교과목 등록 폼
    Route::post('store', [ClassesController::class, 'store'])->name('classes.store'); // 교과목 등록
    Route::get('edit/{classId}', [ClassesController::class, 'edit'])->name('classes.edit'); // 교과목 변경 폼
    Route::patch('update/{classId}', [ClassesController::class, 'update'])->name('classes.update'); // 교과목 변경
    Route::delete('delete/{classId}', [ClassesController::class, 'destroy'])->name('classes.destroy'); //교과목 삭제
    Route::post('/register/{classId}', [ClassesController::class, 'register'])->name('classes.register'); // 수강신청 및 수강취소
    Route::get('/users/{classId}', [ClassesController::class, 'users'])->name('classes.users'); // 수강신청한 사용자 리스트
});
