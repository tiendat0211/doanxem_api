<?php

namespace App\Http\Controllers\Members;


use App\Models\User;
use Carbon\Carbon;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\MediaService;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Post;
use Pawlox\VideoThumbnail\Facade\VideoThumbnail;

class UserController extends Controller
{

    public function postedList(Request $request,$user_uuid) {
        Carbon::setLocale('vi');
        $user = Auth::user();
        $posts = Post::with('postReactions')
            ->where('user_id',$user->id)
            ->orderByDesc('created_at')
            ->paginate()->through(function ($post) use ($user)  {
                $post['time'] = $post->created_at->diffForHumans();
                $post['user_action'] = @$post->postReactions->where('user_id',$user->id)->first()->react ?? 'none';
                return $post;
        });
        return view('member.user.postedlist',compact('posts','user'));
    }

    public function viewNew(Request $request,$user_uuid) {
        $user = User::where('user_uuid',$user_uuid)->first();
        if (!$user) {
            abort(404);
        }
        return view('member.posts.addnew');
    }

    public function storeFile(Request $request,MediaService $mediaService,$userId)
    {
        $user = Auth::user();
        if ($user->user_uuid != $userId) {
            abort(404);
        }
        $message = [
            'file.required' => "Bạn phải nhập ảnh cho bài viết",
            'file.max' => 'File có kích thước quá lớn, vui lòng thử lại',
            'file.mimes' => 'File không đúng định dạng, vui lòng thử lại',
        ];
        $validate = Validator::make($request->all(),
            ['file' => 'required|mimes:jpg,jpeg,png,gif,mp4,avi,wmv,mov,flv,ts,m3u8,webm|max:16000'],
            $message);
        if ($validate->fails()) return response($validate->errors()->first(),400);
        $data = [];
        $requestFile = $request->file('file');
        $storeFile = $mediaService->store($requestFile);
        $file = new File();
        $thumbInfo = new File();
        if ($storeFile['type'] == 'image') {
            $file->url = $storeFile['path'];
            $file->file_type = 'image';
        } elseif ($storeFile['type'] == 'video') {
            $file->url =  $storeFile['path'];
            $file->file_type = 'video';
            $uid = Str::uuid();
            $thumb_name = $uid . '.jpg';
            $ffprobe = FFProbe::create([
                'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                'ffprobe.binaries' => '/usr/bin/ffprobe'
            ])->streams($requestFile)->videos()->first();
            $video_dimensions = $ffprobe->getDimensions();
            $width = $video_dimensions->getWidth();
            $height = $video_dimensions->getHeight();
            VideoThumbnail::createThumbnail($requestFile, storage_path('app/thumbnails'),$thumb_name, 0,$width,$height);
            $link = 'https://doanxem.s3.ap-southeast-1.amazonaws.com/thumbnails/'.$thumb_name;
            $thumb = Storage::disk('thumbnails')->get($thumb_name);
            if (Storage::disk('s3')->put('thumbnails/'.$thumb_name,$thumb)) {
                Storage::disk('thumbnails')->delete($thumb_name);
            } else {
                Storage::disk('thumbnails')->delete($thumb_name);
                return response('Đang có lỗi xảy ra vui lòng thử lại sau',500);
            }
            $thumbInfo->file_uuid = $uid;
            $thumbInfo->file_type = 'thumbnail';
            $thumbInfo->url = $link;
            $thumbInfo->user()->associate($request->user());
        }
        else {
            abort(403);
        }
        $file->user()->associate($request->user());
        $file->file_uuid = Str::uuid();
        $file->save();
        if ($file->file_type == 'video') {
            $file->thumbnail()->save($thumbInfo);
            $data['thumbnail_url'] = $thumbInfo->url;
        }
        $data['image_url'] = $file->url;
        $data['image_uuid'] = $file->file_uuid;
        return $this->sendResponse($data,'Đã tải ảnh lên');
    }

    public function store(Request $request,$userId)
    {
        $request->validate([
            'title' => 'required|min:5|max:255'
        ]);
        $user = Auth::user();
        if ($user->user_uuid != $userId) {
            abort(404);
        }
        $file = File::where('file_uuid', $request->get('uuid'))->first();

        $post = new Post();
        $post->title = $request->get('title');
        $post->image = $file->url;
        $post->status = 'pending';
        $post->share = 0;
        $post->post_uuid = Str::uuid();
        if ($file->file_type == 'video') {
            $post->thumbnail = $request->get('thumbnail');
        }
        $post->user()->associate($request->user());
        $post->save();
        $post->file()->save($file);

        return $this->sendResponse($post,'Đăng Thành Công');
    }
}
