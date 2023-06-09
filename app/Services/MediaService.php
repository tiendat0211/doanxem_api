<?php


namespace App\Services;


use Exception;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public static function store($file, $fileType = "post")
    {
        $extension = @$file->getClientOriginalExtension() ?? '';
        if (!$extension) {
            throw new Exception('File Không đúng định dạng');
        }
        $imageEtx = ['png', 'jpg', 'jpeg', 'gif'];
        $videoEtx = ['mp4', 'm4v', 'webm', 'mkv','mov','flv','m3u8','ts','wmv','avi'];

        if ($fileType == "post")
            if (in_array(strtolower($extension), $imageEtx)) {
                $path = $file->store('image', 's3');
            } else if (in_array(strtolower($extension), $videoEtx)) {
                $path = $file->store('video', 's3');
            }else {
                throw new Exception('File upload is not image or video');
            }
        else {
            $path = $file->store('user', 's3');
        }

        return [
            'type' => in_array($extension, $imageEtx)? 'image' : 'video',
            'path' => Storage::disk('s3')->url($path)
        ];
    }

    public static function sync($file, $type = 'post')
    {
        $ext = @$file->getClientOriginalExtension() ?? '';
        if (!$ext) {
            throw new Exception('File Không đúng định dạng');
        }
        $imageEtx = ['png', 'jpg', 'jpeg', 'gif'];
        if ($type == "post") {
            $folder = 'video';
            if (in_array($ext, $imageEtx)) {
                $folder = 'image';
            }
        } else {
            $folder = $type;
        }
        $filename = uniqid() . '.' . $ext;
        $link = 'https://doanxem.s3.ap-southeast-1.amazonaws.com/' . $folder . '/' . $filename;
        if (Storage::disk('s3')->put($folder . '/' . $filename, $file))
            return $link;
        return "Can not save image.";
    }
}
