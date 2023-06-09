<?php

namespace App\Http\Controllers\API;

use App\Events\SendMail;
use App\Models\FcmToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'checkTokenExpired']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->sendError(422, 'Tên đăng nhập hoặc mật khẩu không đúng!');
            }
        } catch (JWTException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }

        $lastWeek = now()->subDays(7);

        $user = User::where('email', $credentials['email'])->first();

        // $timeCreatedUser = Carbon::parse($user->created_at);
        // if (!$user->email_verified_at && $lastWeek->gt($timeCreatedUser)) {
        //     event(new SendMail($user));
        //     return $this->sendError(403, 'Một email đã được gửi đến để xác thực, vui lòng kiểm tra hòm thư.');
        // }

        $data = [
            'user' => $user,
            'token' => $token,
        ];
        return $this->sendResponse($data, 'Đăng nhập thành công');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return $this->sendResponse(auth()->user(), 'Lấy thông tin người dùng thành công');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $fcm = FcmToken::where('user_id', auth()->user()->id)->first();
        if ($fcm) {
            $fcm->delete();
        }
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    public function register(Request $request)
    {
        $user_uuid = Str::uuid();
        $user = User::where('api_token', $user_uuid)->first();
        while ($user != null) {
            $api_token = Str::random(20);
            $user = User::where('user_uuid', $user_uuid)->first();
        }
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'avatar' => 'https://ui-avatars.com/api/?name=' . Str::slug($request->name, '+'),
            'user_uuid' => $user_uuid
        ]);

        $data = [
            'api_token' => $api_token,
            'user' => $user,
        ];
        return $this->sendResponse($data, 'Đăng ký người dùng thành công');
    }

    public function checkTokenExpired()
    {
        $response = (int) auth('api')->check();
        try {
            if (!app(\Tymon\JWTAuth\JWTAuth::class)->parseToken()->authenticate()) {
                return $this->sendError(401, 'User not found');
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->sendError(401, 'Token is expired');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->sendError(401, 'Token is invalid');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->sendError(401, 'Token is absence');
        }
        return $this->sendResponse($response, 'Token true');
    }

    public function resetPassword(Request $request)
    {
        $user = auth()->user();
        $oldPassword = $request->get('password');
        $newPassword = $request->get('new_password');
        $confirmPassword = $request->get('confirm_password');
        if (!$user) {
            return $this->sendError(403,'Không có quyền');
        }
        if (!$oldPassword || !$newPassword || !$confirmPassword) {
            return $this->sendError(400,'Thiếu dữ liệu');
        }
        $credentials =Auth::guard('api')->validate(['password' => $oldPassword,'email' => $user->email]);
        if (!$credentials) {
            return $this->sendError(400,'Sai mật khẩu');
        }
        if ($newPassword != $confirmPassword) {
            return $this->sendError(400,'Xác nhận mật khẩu không đúng');
        }
        DB::table('users')->where('id',$user->id)->update(['password' => Hash::make($newPassword)]);
        return $this->sendResponse([],'Thành công thay đổi mật khẩu');
    }
}
