<?php

namespace App\Http\Controllers\API;

use App\Helpers\Constant;
use App\Invite;
use App\Post;
use App\PostReaction;
use App\Report;
use App\Services\MediaService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function getLink(Request $request)
    {
	if ($request->user_id) {
        	$user = User::where('id', $request->user_id)->first();
	}else {
		$user = auth()->user();
	}

        $hash = Str::random(64);

        $url = url('/') . '/invite-friend?user_id=' . $user->user_uuid . '&hash='.$hash;

        $invite = Invite::where('user_id', $user->user_uuid)->first();

        if (!$invite) {
            $invite = Invite::create([
                'link' => $url,
                'user_id' => $user->user_uuid,
            ]);
        }
        return $this->sendResponse($invite, 'Lấy link giới thiệu thành công');
    }
}

