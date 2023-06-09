<?php

namespace App\Http\Controllers\API;

use App\Models\FcmToken;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Post;
use App\Services\MediaService;
use App\Models\User;
use App\Models\UserOpenApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function userInfo(Request $request)
    {
        $user = User::with(['posts' => function ($query) {
          $query->where('status',Post::APPROVAL);
        }])->where('user_uuid',$request->uuid)->first()->makeHidden('id');
        if(!$user) {
            return $this->sendError(404,'Không tìm thấy người dùng');
        }

        return $this->sendResponse($user,'Lấy danh sách thành công');
    }

    public function postInfo()
    {
        $user = auth()->user();
        $posts = $user->posts()->select('title', 'image', 'share', 'user_id', 'post_uuid', 'created_at', 'status', 'like', 'heart', 'wow', 'haha', 'sad', 'angry')
            ->withCount(['comments'])
            ->with(['user:id,name,email,avatar,user_uuid'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->transform(function ($post) use ($user) {
                $post->url = $post->image;
                $post->status = $this->changeStatus($post->status);
                $post['total_reactions'] = $post->like + $post->heart + $post->haha + $post->wow + $post->sad + $post->angry;
                $post->time = $post->created_at->diffForHumans();
                $post['max_reactions'] = max($post->like, $post->heart, $post->haha, $post->wow, $post->sad, $post->angry);
                if ($user) {
                    $reaction = $post->currentReaction();
                    if (!$reaction) {
                        $post->reaction = 'none';
                    } else {
                        $post->reaction = $reaction;
                    }
                }
                return $post;
            })->flatten();
        return $this->sendResponse($posts, 'Lấy danh sách post thành công');
    }

//    public function changeAvatar(Request $request)
//    {
//        return $this->sendResponse($user, 'Đổi avatar thành công');
//    }

    public function updateInfo(Request $request)
    {
        $user = auth()->user();
        $requestFile = $request->file('avatar');
        $requestName = $request->get('name');
        $postUrl = null;
        if (!$user) {
            return $this->sendError(404,'Không tìm thấy người dùng');
        }
        if (!$requestName) {
            if (!$requestFile) {
                return $this->sendError(403,'Thiếu dữ liệu');
            }
            $postUrl = MediaService::store($requestFile, 'user');
        }
        if ($requestName) {
            if ($requestFile) {
                $postUrl = MediaService::store($requestFile, 'user');
            }
            $user->name = $requestName;
        }
        if ($postUrl != null) {
            File::create([
                'user_id' => $user->id,
                'file_uuid' => Str::uuid(),
                'url' => $postUrl['path'],
                'file_type' => 'avatar'
            ]);
            $user->avatar = $postUrl['path'];
        }
        $user->save();
        return $this->sendResponse($user, 'Cập nhật tên người dùng thành công');
    }

    public function blockUser(Request $request)
    {
        $curUser = auth()->user();

        if (!$request->user_id) {
            return $this->sendError(403, 'CHưa có user id');
        }

        $blocked = User::findOrFail($request->user_id);

        if (!$blocked) {
            return $this->sendError(404, 'Không tìm thấy người bị block');
        }

//        if (!$request->action || !in_array($request->action, [User::BLOCK_POST, User::BLOCK_POST])) {
//            return $this->sendError(403, 'Sai dữ liệu action');
//        }

        $blockedList = $curUser->blockedAccounts()->pluck('blocker_id')->toArray();

//        $action = $request->get('action');


        if (in_array($blocked->id, $blockedList)) {
            return $this->sendError(404, 'Bạn đã khóa người dùng này');
        }

        $curUser->blockedAccounts()->attach($blocked->id, ['action' => 'user']);

        return $this->sendResponse($blocked, 'Khóa người dùng thành công');
    }

    public function getBlockedList()
    {
        $curUser = auth()->user();

        $blockedList = $curUser->load('blockedAccounts')->blockedAccounts;

        return $this->sendResponse($blockedList, 'Get blocked account successfully');
    }

    public function unblockAccount(Request $request)
    {
        $user = auth()->user();

        if (!$request->user_id) {
            return $this->sendError(403, 'CHưa có user id');
        }

        $blocked = User::findOrFail($request->user_id);

        if (!$blocked) {
            return $this->sendError(404, 'Không tìm thấy người bị block');
        }

        $user->blockedAccounts()->detach($blocked->id);
        return $this->sendResponse($blocked, 'Unblocked account successfully');
    }

    public function changeStatus($status)
    {
        switch ($status) {
            case Post::APPROVAL:
                return 'Đã duyệt';
            case POST::PENDING:
                return 'Đợi duyệt';
            default:
                return 'Bị từ chối';
        }
    }

    public function getFcmToken(Request $request)
    {
        if (!$request->fcm_token) {
            return $this->sendError(403, 'Thiếu fcm token');
        }

        if (!$request->api_token) {
            return $this->sendError(403, 'Thiếu api token');
        }

        $user = auth()->user();

        $checkTokenExist = FcmToken::where('fcm_token', $request->fcm_token)->where('api_token', $request->api_token)->first();

        if (!$checkTokenExist) {
            $fcm = FcmToken::create([
                'user_id' => $user->id,
                'fcm_token' => $request->fcm_token,
                'timezone' => $request->timezone,
                'api_token' => $request->api_token,
                'device_name' => $request->device_name,
                'device_model' => $request->device_model,
                'app_version' => $request->app_version,
                'os_version' => $request->os_version,
            ]);
        } else {
            $fcm = FcmToken::where('fcm_token', $request->fcm_token)->orWhere('api_token', $request->api_token)->first();
            if ($fcm) {
                $fcm->delete();
                $fcm = FcmToken::create([
                    'user_id' => $user->id,
                    'fcm_token' => $request->fcm_token,
                    'timezone' => $request->timezone,
                    'api_token' => $request->api_token,
                    'device_name' => $request->device_name,
                    'device_model' => $request->device_model,
                    'app_version' => $request->app_version,
                    'os_version' => $request->os_version,
                ]);
            }
        }

        //luu thoi gian nguoi dung mo app
        UserOpenApp::create([
            'user_id' => $user->id,
            'open_time' => now()->format('Y-m-d H:i:s')
        ]);
        return $this->sendResponse($fcm, 'Lưu thành công');
    }


    public function removeFcmToken(Request $request)
    {
        $user = auth()->user();
        if (!$request->fcm_token) {
            return $this->sendError(403, 'Thiếu fcm token');
        }

        $fcm = $user->fcmTokens()->where('fcm_token', $request->fcm_token)->first();
        if (!$fcm) {
            return $this->sendError(403, 'Không đăng xuất được rồi bạn ơi, kiểm tra lại xem');
        }
        $fcm->delete();

        return $this->sendResponse([], 'Xóa thành công');
    }

    public function approvedPost()
    {
        $user = auth()->user();
        $posts = $user->posts()->approval()->select('id', 'image', 'post_uuid', 'created_at', 'thumbnail')->get();
        foreach ($posts as $post) {
            if ($post->thumbnail) {
                $post->image = $post->thumbnail;
            }
        }
        return $this->sendResponse($posts, 'Lấy danh sách thành công');
    }

    public function pendingPost()
    {
        $user = auth()->user();
        $posts = $user->posts()->pending()->select('id', 'image', 'post_uuid', 'created_at', 'thumbnail')->get();
        foreach ($posts as $post) {
            if ($post->thumbnail) {
                $post->image = $post->thumbnail;
            }
        }
        return $this->sendResponse($posts, 'Lấy danh sách thành công');
    }

    public function savedPost()
    {
        $user = auth()->user();
        $posts = $user->savedPost();
        return $this->sendResponse($posts, 'Lấy danh sách thành công');
    }

}
