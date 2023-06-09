<?php

namespace App\Http\Controllers\API;

use App\Helpers\Device;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        if (!$request->email || !$request->name || !$request->password) {
            return $this->sendError(403, 'Dữ liệu bị thiếu');
        }

        if (mb_strtolower($request->password) !== mb_strtolower($request->confirm)) {
            return $this->sendError(403, 'Mật khẩu xác nhận không khớp với mật khẩu');
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->sendError(403, 'Email không đúng định dạng');
        }

        if (strlen($request->password) <6) {
            return $this->sendError(403, 'Mật khẩu phải có ít nhất 6 ký tự');
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return $this->sendError('403', 'Email đã được đăng ký, vui lòng thử lại');
        }
        $user_uuid = Str::uuid();
        $user = User::where('user_uuid', $user_uuid)->first();
        while ($user != null) {
            $user_uuid = Str::uuid();
            $user = User::where('user_uuid', $user_uuid)->first();
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'avatar' => 'https://ui-avatars.com/api/?name=' . Str::slug($request->name, '+'),
            'user_uuid' => $user_uuid
        ]);
        $invite = Invite::where('user_id', $request->invite_user)->first();
        $message = 'Đăng ký người dùng thành công';
        if ($invite) {
            $inviter = User::where('user_uuid', $request->invite_user)->first();
            $invite->amount += 1;
            $invite->save();
            $link = Device::detectDevice();
            $message = 'Bạn đã đăng ký tài khoản thành công từ link chia sẻ của ' . $inviter->name;
            return $this->sendResponse($link, $message);
        }
        return $this->sendResponse($user, $message);
    }
}
