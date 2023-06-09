<?php

// trang chủ show danh sách posts
use App\Http\Controllers\Members\CommentController;
use App\Http\Controllers\Members\UserController;
use App\Http\Controllers\Members\PostController;
use App\Http\Controllers\Members\ReplyController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::post('/{id}/comments',[CommentController::class,'store'])->name('post.comment');
    Route::post('/{id}/replies',[ReplyController::class,'store'])->name('post.reply');
    Route::post('/{id}/{reaction}',[PostController::class,'handleReactions'])->name('post.react');
    Route::post('/{postId}/react-comments/{commentId}/like',[CommentController::class,'upvote']);
    Route::post('/{postId}/react-comments/{commentId}/dislike',[CommentController::class,'downvote']);
});
Route::prefix('user')->controller(UserController::class)->group(function () {

    Route::get('/{id}/create-post','viewNew')->name('get.addform');
    Route::post('/{id}/create-post','store');
    Route::post('/{id}/post-file-url','storeFile');
    Route::get('/{id}/posted-list','postedList');
});
