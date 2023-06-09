<?php
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function(){
    Route::get('/','index')->name('home');
    Route::get('/posts/pending','pendingPosts')->name('posts.pending');
    Route::get('/posts/deleted','deletedPosts')->name('posts.deleted');
    Route::get('/posts','showpost')->name('showpost');
    Route::get('/activated-users','showActive')->name('active_user');
    Route::get('/banned','showbanned')->name('banned');
    Route::get('/hidden-posts','hiddenPosts')->name('hide_post');
    Route::get('/loadmore','loadMore')->name('loadMore');
});
/**
 *  Route::get('/unapprove', [PostController::class, 'showunapprove'])->name('unapprove');
 *  Route::post('post/show_all', [PostController::class, 'showAllPost'])->name('post_show_all');
 *  Route::get('/deletedpost', [PostController::class, 'showdeleted'])->name('deletedpost');
 *  Route::get('/posts/{id}', [HomeController::class, 'delete'])->name('delete_post');
 */

Route::controller(PostController::class)->group(function(){
    Route::get('/posts/detail/{id}','showdetailPost')->name('showdetailPost');
    Route::prefix('post')->group(function(){
        Route::post('/show', 'showPost')->name('post_show');
        Route::post('/hide', 'hidePost')->name('post_hide');
        Route::post('/action','actionPost')->name('action_post');
    });
});

Route::get('/images/{id}', [CommentController::class, 'show'])->name('show_image');

Route::get('/user/hide/{id}', [HomeController::class, 'userdelete'])->name('destroy_user');
Route::get('/user/show/{id}', [HomeController::class, 'restore'])->name('restore');

Route::get('/profile',[UserController::class,'profile'])->name('profile');
Route::post('/edit-password', [UserController::class, 'editPassword']);
Route::post('/edit-profile', [UserController::class, 'editProfile']);

Route::get('/posts/{id}/comment', [HomeController::class, 'showcomment'])->name('showcomment');
Route::get('/comment/delete/{id}', [HomeController::class, 'destroyComment'])->name('destroycomment');



Route::prefix('api')->name('api.')->group(function () {
    Route::get('delete-post/{uuid}', [PostController::class, 'deletePost'])->name('post.delete');
});
