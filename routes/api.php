<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\InviteController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ReplyController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\API\VersionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::post('login', [AuthController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('posts', [PostController::class,'index']); // checked
Route::get('new', [PostController::class,'new']); // checked
Route::get('top', [PostController::class,'top']); // checked
Route::get('hot', [PostController::class,'hot']); // checked
Route::get('post-detail', [PostController::class,'postDetail']); // checked
Route::get('posts/comments', [CommentController::class,'index']);
Route::get('posts/replies',[ReplyController::class,'index']);
Route::get('user',[UserController::class,'userInfo']);
/**
 * maintain
 */
//Route::get('term-of-use', [PostController::class,'termOfUse']);

//Route::get('/send-new-version', [VersionController::class,'sendNewVersionNotify']);
//Route::get('check-token', [AuthController::class,'checkTokenExpired']);
// verify email
//Route::get('/email/resend', [VerificationController::class,'resend'])->name('verifications.resend');
//Route::get('/email/verify/{id}/{hash}', [VerificationController::class,'verify'])->name('verifications.verify');
//Route::post('add-logo', [VersionController::class,'addLogo']);
/**
 *
 */

Route::group([
    'middleware' => ['jwt.verify']
], function () {
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('reset-password', [AuthController::class,'resetPassword']);
    /**
     * các tác động của user vào bài viết của mình hoặc bài viết khác
     */
    Route::prefix('posts')->group(function () {
        Route::post('store', [PostController::class,'store']); // checked
        Route::post('reaction', [PostController::class,'reaction']); // need review
        Route::post('delete-post', [PostController::class,'delete']); // need review
        Route::post('save-post', [PostController::class,'savePost']); // need review
        Route::post('edit', [PostController::class,'edit']); // need review
        Route::post('report', [PostController::class,'report']); // need review
    });

    Route::post('/save-fcm', [UserController::class,'getFcmToken']); // need review
    Route::post('/remove-fcm', [UserController::class,'removeFcmToken']); // need review
    /**
     * các tác động của user vào profile hoặc vào user khác
     */
    Route::get('/profile', [AuthController::class,'profile']);  // need review

    Route::prefix('user')->group(function () {
        Route::get('block-list', [UserController::class,'getBlockedList']); // need review
        Route::post('block-user', [UserController::class,'blockUser']); // need review
        Route::post('unblock-user', [UserController::class,'unblockAccount']); // need review
        Route::post('edit', [UserController::class,'updateInfo']); // need review
        Route::get('approved_posts', [UserController::class,'approvedPost']); // need review
        Route::get('pending_posts', [UserController::class,'pendingPost']); // need review
        Route::get('saved_posts', [UserController::class,'savedPost']); // need review
    });

    /**
     * các tác đông của user vào comments
     */
    Route::post('comments/upvote', [CommentController::class,'upvote']);
    Route::post('comments/downvote', [CommentController::class,'downvote']);
    Route::post('comments/store', [CommentController::class,'store']);
    Route::post('replies', [ReplyController::class,'store']);
    Route::post('replies/upvote', [ReplyController::class,'upvote']);
    Route::post('replies/downvote', [ReplyController::class,'downvote']);

    //share link de moi them moi nguoi
//    Route::get('/link-share', 'InviteController@getLink');
    /**
     * @removed

        Route::post('/change-avatar', [UserController::class,'changeAvatar']);
        Route::get('/uploader', [UserController::class,'postInfo']);
        Route::post('image/store', 'PostController@imageStore');
        Route::get('/test', [PostController::class,'test']);
        Route::get('loadmore/{page}', 'PostController@loadMore');
        Route::post('/save-time', 'UserController@addUserOpenTime');
        Route::post('reset-password', 'ResetPasswordController@sendMail');
        Route::put('reset-password/{token}', 'ResetPasswordController@reset');
        Route::post('logout', [LoginController::class,'logOut']);
    */
});
//
//
//
//Route::get('/test11', function () {
//    $data = [
//        'channel' => 'testttt',
//        'message' => 'ok',
//        'team_name' => 'sphoton',
//        'channel_type' => 'channel_name',
//        'team_id' => 1
//    ];
//    $data_string = json_encode($data);
//
//    $curl = curl_init('https://ai.sphoton.com:3001/messages');
//
//    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
//    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
//
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//
//    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//            'Content-Type: application/json',
//            'Content-Length: ' . strlen($data_string))
//    );
//    $result = curl_exec($curl);
//    curl_close($curl);
//
//    return $result;
//});
