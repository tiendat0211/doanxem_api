<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
//use App\Jobs\SendNewVersionNotify;
use App\Services\MediaService;
//use App\Services\UploadService;
use App\Models\User;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
//use Intervention\Image\Facades\Image;

class VersionController extends Controller
{
    public function sendNewVersionNotify()
    {
        $users = User::get();
        foreach ($users as $user) {
            SendNewVersionNotify::dispatch($user);
        }
        return $this->sendResponse([], 'Thông báo đã được gửi');
    }

    public function addLogo(Request $request)
    {
        $data = $request->all();

        $logo = [];

        if ($data['links'] ?? false) {
            $links = explode(PHP_EOL, $data['links']);
            foreach ($links as $link) {
                try {
                    $image = UploadService::addLogo($link, $request->position);
                    array_push($logo, $image);
                }catch(\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }

        unset($data['links']);

        foreach ($data as $index => $item) {
            if (preg_match('/image.*/', $index)) {
                try {
                    $uploadToServer = MediaService::store($item);
                    $addLogoImage =UploadService::addLogo($uploadToServer, $request->position);
                    array_push($logo, $addLogoImage);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }

        return $this->sendResponse($logo, 'thực hiện thành công');
    }
}
