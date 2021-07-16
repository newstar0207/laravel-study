<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostsController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard'); // 라우터에 전달되기전 로그인 여부를 체크함

require __DIR__ . '/auth.php';



Route::get('/test', [PostsController::class, 'test'])->name('test');
Route::get('/posts/myindex', [PostsController::class, 'myindex'])->name('posts.myindex');
Route::get('/posts/create', [PostsController::class, 'create']) /*->middleware(['auth'])*/;
Route::post('/posts/store', [PostsController::class, 'store'])->name('posts.store') /*-> middleware(['auth']) */;
Route::get('/posts/index', [PostsController::class, 'index'])->name('posts.index');
Route::get('/posts/show/{id}', [PostsController::class, 'show'])->name('posts.show'); // default 는 get 방식
Route::get('/search', [PostsController::class, 'search'])->name('posts.search');
Route::get('/posts/{post}', [PostsController::class, 'edit'])->name('posts.edit'); // router parameter : {post}
Route::put('/posts/{id}', [PostsController::class, 'update'])->name('posts.update'); // router parameter : {id}
Route::delete('/posts/{id}', [PostsController::class, 'destroy'])->name('posts.delete'); // router parameter : {id}
Route::get('/char/index', [ChartController::class, 'index'])->name('chart');
Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
