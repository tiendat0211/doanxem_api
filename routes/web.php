<?php

//use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Members\CommentController;
use App\Http\Controllers\Members\HomeController;
use App\Http\Controllers\Members\PostController;
use App\Http\Controllers\Members\ReplyController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Post;

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

Route::get('/landing', [HomeController::class, 'landing']);

//social login
Route::get('/auth/redirect/{social}', [AuthenticatedSessionController::class, 'redirect'])->name('social.login');
Route::get('/auth/callback/{social}', [AuthenticatedSessionController::class, 'callback']);

Route::controller(HomeController::class)->group(function () {
    Route::get('/','new')->name('home');
//    Route::get('/new','new')->name('new');
    Route::get('/top','top')->name('top');
    Route::get('/hot','hot')->name('hot');

});
Route::get('/posts/{id}', [PostController::class,'show'])->name('post.detail');
Route::get('/posts/{id}/comments',[CommentController::class,'index'])->name('post.comment.index');
Route::get('/posts/{id}/comments/loadmore',[CommentController::class,'loadMore'])->name('comment.loadmore');
Route::get('/posts/{id}/comments/{commentId}/show-replies',[ReplyController::class,'index'])->name('reply.index');

require __DIR__.'/auth.php';

