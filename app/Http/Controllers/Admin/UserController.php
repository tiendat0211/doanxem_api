<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $total_post = Post::get()->count();
        $total_user = User::where('role', 'member')->get()->count();
        $total_post_hide = Post::where('status', 'hide')->get()->count();
        $page_name = 'Profile';
        $data = [
            'page_name' => $page_name,
            'user' => $user,
            'total_post' => $total_post,
            'total_user' => $total_user,
            'total_post_hide' => $total_post_hide,
        ];
        return view('admin.profile')->with($data);
    }

    public function editProfile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ], [
            'name.required' => 'Chưa nhập họ và tên',
            'email.required' => 'Chưa nhập email',
            'email.email' => 'Chưa đúng định dạng email',
        ]);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 400, $validate->errors()->first());
        }

        $user = auth()->user();
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        $user->save();
        return $this->sendResponse(200, 'Đổi mật khẩu thành công');
    }
    public function editPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'confirm_password.required' => 'Vui lòng nhập mật khẩu xác nhận',
            'confirm_password.same' => 'Mật khẩu xác nhận không giống với mật khẩu',
            'new_password.min' => 'Mật khẩu chứa ít nhất 6 ký tự',
        ]);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 400, $validate->errors()->first());
        }

        $user = auth()->user();
        if (!Hash::check($request->get('current_password'), $user->password)) {
            $message = new MessageBag();
            return $this->sendError(400, 'Mật khẩu hiện tại không chính xác', $message->add('current_password', 'Mật khẩu hiện tại không chính xác'));
        }

        $user->password = Hash::make($request->get('new_password'));

        return $this->sendResponse(200, 'Đổi mật khẩu thành công');
    }

}
