<?php

namespace App\Http\Controllers\API;

//use App\Gallery;
use App\Helpers\Constant;
//use App\Notifications\SendPushNotification;
use App\Models\Comment;
use App\Models\File;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\PostReaction;
//use App\Report;
use App\Notifications\SendPushNotification;
use App\Services\MediaService;
use App\Models\User;
use Carbon\Carbon;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Pawlox\VideoThumbnail\Facade\VideoThumbnail;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{
    private $share = 0;

    private $seeders = ['nguyetha9316@gmail.com'];

    private $notRealReaction = 100;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        if ($request->bearerToken() && trim($request->bearerToken()) !== 'Bearer') {

            $this->middleware('jwt.auth');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * fixed:
     *      - paginated
     *
     *
     *      - outdated
     *
     */
    public function index(Request $request)
    {
        Carbon::setLocale('vi');
        $post = Post::query();
        $user = Auth::user();
        if ($user) {
            $user = $user->load(['blockedAccounts','blockerAccounts']);
            $blocked = $user->blockedAccounts->pluck('id')->toArray(); //lay cac tai khoan bi block
            $blocker = $user->blockerAccounts->pluck('id')->toArray(); //lay cac tai khoan block minh
            $post = $post->unblock($blocked, $blocker);
        }
        $defaultGallery = $user ? @$user->galleries()->default()->first() : '';

        $posts = $post->orderBy('created_at', 'desc')
            ->with(['user:id,name,avatar,email,user_uuid'])
            ->withCount('comments as total_comments')
            ->where('status','approval')
            ->paginate()->through(function ($post,$key) use ($user,$defaultGallery) {
                $post['time'] = $post->created_at->diffForHumans();
                $post['user_action'] = $post->currentReaction($user);
                $post['isSaved'] = ($defaultGallery ? $defaultGallery->posts()->wherePivot('post_id',$post->id)->first() : '') ? true : false;
                return $post;
            })->flatten();
        return $this->sendResponse($posts, 'Lấy danh sách post thành công');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reaction(Request $request)
    {
        $message = [
            'post_uuid.required' => 'Thiếu uuid',
            'reaction.required' => 'Hãy chọn một reaction',
        ];
        $validate = Validator::make($request->all(),[
            'post_uuid' => 'required',
            'reaction' => 'required',
        ],$message);
        if ($validate->fails()) return $this->sendError(Response::HTTP_BAD_REQUEST,$validate->errors()->first());
        $userReaction = $request->get('reaction');
        $post = Post::with('postReactions')->where('post_uuid',$request->get('post_uuid'))->first();

        if (!$post) {
            return $this->sendError(404, 'Không tìm thấy bài viết');
        }

        $user = auth()->user();

        $reaction = $post->postReactions->where('user_id', $user->id)->first();

        //neu la tai khoan cua Nguyet Ha hoac Thoan thi cho them 100 reaction :))
        try {
            DB::beginTransaction();
            if (in_array(auth()->user()->email, $this->seeders)) {
                if (!$reaction) {
                    //reaction that be liked by real user
                    $reaction = PostReaction::create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                        'react' => $userReaction,
                        'share' => Constant::SHARE,
                    ]);
                    $post->{$userReaction} += 1;

                    //reaction that be liked by not real user
                    $data = [];
                    for ($i = 0; $i < $this->notRealReaction; $i++) {
                        $data[] = [
                            'user_id' => getRandomUser(),
                            'post_id' => $post->id,
                            'react' => $userReaction,
                            'share' => Constant::SHARE,
                        ];
//                        array_push($data, [
//                            'user_id' => getRandomUser(),
//                            'post_id' => $post->id,
//                            'react' => $userReaction,
//                            'share' => Constant::SHARE,
//                        ]);
                    }
                    DB::table('post_users')->insert($data);
                    $post->{$userReaction} += $this->notRealReaction;
                } else {
                    //neu tha react trung voi react hien tai thi bo like
                    if ($userReaction === 'none') {
                        $post->{$reaction->react} -= 1;
                        $reaction->update(['react' => $userReaction]);
                    } else {
                        if ($reaction->react === $userReaction) {
                            $post = $post->unsetRelation('postReactions');
                            return $this->sendResponse($post, 'like bài viết thành công');
                        }
                        if ($reaction->react !== 'none') {
                            $post->{$reaction->react} -= 1;
                        }
                        $reaction->update(['react' => $userReaction]);
                        $post->{$userReaction} += 1;
                    }
                }
                $post->save();
                $this->setCache("doanxem:number_of_posts:{$user->id}", getTotalReaction($post) + 1);
                $reaction->save();
            } else {
                if (!$reaction) {
                    $reaction = PostReaction::create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                        'react' => $userReaction,
                        'share' => Constant::SHARE,
                    ]);
                    $post->{$userReaction} += 1;
                } else {
                    //neu tha react trung voi react hien tai thi bo like
                    if ($userReaction === 'none') {
                        $post->{$reaction->react} -= 1;
                        $reaction->update(['react' => $userReaction]);
                    } else {
                        if ($reaction->react !== 'none') {
                            $post->{$reaction->react} -= 1;
                        }
                        $reaction->update(['react' => $userReaction]);
                        $post->{$userReaction} += 1;

                    }
                }
                $post->save();
                $reaction->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        //unset relation from collection
        $post = $post->unsetRelation('postReactions');

        $reaction = getTotalReaction($post);

        try {
            $user = $post->user;
            switch ($reaction) {
                case 1:
                    $user->notify(new SendPushNotification($user, 'Thông báo', 'Có người vừa like bài viết của bạn kìa mau vào xem đi nào!!'));
                    break;
                case config('notification.emerging'):
                    $user->notify(new SendPushNotification($user, 'Thông báo', 'Bài viết của bạn đang có nhiều lượt thích rồi đó, xem ngay nào!!'));
                    break;
                case config('notification.famous'):
                    $user->notify(new SendPushNotification($user, 'Thông báo', 'Bài viết đang nổi tiếng rồi kìa, còn chần chừ gì mà không vào xem!!'));
                    break;
                case config('notification.top'):
                    $user->notify(new SendPushNotification($user, 'Thông báo', 'Có bài viết lên top rồi này, đỉnh của chóp chưa'));
                    break;
                default:

            }
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendResponse($post, 'like bài viết thành công');
        }

//        $this->sendLikeNotify($post, $user);

        return $this->sendResponse($post, 'like bài viết thành công');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return $this->sendError(404, 'Người dùng không tồn tại');
        }
        $message = [
            'title.required' => 'Không được để trống tiêu đề',
            'image.required' => 'Không được để trống ảnh',
            'image.mimes' => 'File upload phải thuộc jpg,jpeg,png,gif,mp4,avi,wmv,mov,flv,ts,m3u8,webm',
            'image.max' => 'File size Không được quá 15mb'
        ];
        $validate = Validator::make($request->all(),[
            'title' => 'required',
            'image' => 'required|mimes: jpg,jpeg,png,gif,mp4,avi,wmv,mov,flv,ts,m3u8,webm|max:16000'
        ],$message);
        if ($validate->fails()) return $this->sendError(Response::HTTP_BAD_REQUEST,$validate->errors()->first());
        $requestFile = $request->file('image');
        $data = [
            'title' => $request->title,
            'share' => 0,
            'user_id' => $user->id,
            'post_uuid' => Str::uuid(),
            'status' => Post::PENDING
        ];
        try {
                $storeFile = MediaService::store($requestFile);
                $file = new File();
                $thumbInfo = new File();
                $file->file_type = $storeFile['type'];
                $file->url = $storeFile['path'];
                $file->file_uuid = Str::uuid();
                $file->user()->associate(\auth()->user());
//                $postUrl = MediaService::store($file);
                $data['image'] = $storeFile['path'];
                if ($storeFile['type'] === 'video') {
                    $uid = Str::uuid();
                    $thumb_name = $uid . '.jpg';
                    $ffprobe = FFProbe::create([
                        'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                        'ffprobe.binaries' => '/usr/bin/ffprobe'
                    ])->streams($storeFile['path'])->videos()->first();
                    $video_dimensions = $ffprobe->getDimensions();
                    $width = $video_dimensions->getWidth();
                    $height = $video_dimensions->getHeight();
                    VideoThumbnail::createThumbnail($storeFile['path'], storage_path('app/thumbnails'),$thumb_name, 1, $width, $height);
                    $link = 'https://doanxem.s3.ap-southeast-1.amazonaws.com/thumbnails/'.$thumb_name;
                    $thumb = Storage::disk('thumbnails')->get($thumb_name);
                    if (Storage::disk('s3')->put('thumbnails/'.$thumb_name,$thumb)) {
                        Storage::disk('thumbnails')->delete($thumb_name);
                    } else {
                        Storage::disk('thumbnails')->delete($thumb_name);
                        return $this->sendError(Response::HTTP_BAD_GATEWAY,'Đang có lỗi xảy ra vui lòng thử lại sau');
                    }
                    $thumbInfo->file_uuid = $uid;
                    $thumbInfo->file_type = 'thumbnail';
                    $thumbInfo->url = $link;
                    $thumbInfo->user()->associate($user);
                    $data['thumbnail'] = $link;
                }
                $post = Post::create($data);
                $post->file()->save($file);
                if ($file->file_type == 'video'){
                    $file->thumbnail()->save($thumbInfo);
                }
                $data['post'] = $post;
        } catch (\Exception $e) {
            $this->sendError(Response::HTTP_FORBIDDEN, 'Tải ảnh thất bại, vui lòng thử lại');
        }


        return $this->sendResponse($data['post'],'Tải bài viết thành công');
    }

    /**
     * @param $page
     * @return mixed
     */
    public function loadMore($page)
    {
        $posts = Post::whereIn('status', ['new', 'approved'])->get();
        $items = $posts->forPage($page, 10)->values();
        foreach ($items as $item) {
            $data = getimagesize(Config::get('app.url') . $item->image);
            $item['name'] = $item->user->name;
            $item['avatar'] = $item->user->avatar;
            $item['time'] = $item->created_at->diffForHumans();
            $item['comment'] = $item->comments->count();
            $item['apiToken'] = $item->user->api_token;
            $item['image'] = $item->image;
            $item['width'] = $data[0];
            $item['height'] = $data[1];
        }
        return $items;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDetail(Request $request)
    {
        Carbon::setLocale('vi');
        $user = Auth::user();
        if (!$request->post_uuid) {
            return $this->sendError(403, 'Thiếu dữ liệu');
        }
        $defaultGallery = $user ? $user->galleries()->default()->first() : '';
        $post = Post::with('user:id,user_uuid,name,avatar,email')
            ->withCount('comments as total_comments')
            ->where('post_uuid', $request->post_uuid)
            ->first();
        if (!$post) {
            return $this->sendError(404, 'Không tìm thấy bài viết');
        }
        $post->total_reactions = getTotalReaction($post);
        $post->time = $post->created_at->diffForHumans();
        $post->user_action = @$post->postReactions->where('user_id',$user->id)->first()->react ?? 'none';
        $post->isSaved = ($defaultGallery ? $defaultGallery->posts()->wherePivot('post_id',$post->id)->first() : '') ? true : false;

        return $this->sendResponse($post, 'Lấy thông tin bài viết thành công');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => 'Không tìm thấy id bài viết',
        ]);

        if ($validate->fails()) {
            return $this->response($validate->errors(), 404, $validate->errors()->first());
        }

        $post = Post::where('post_uuid', $request->post_id)->first();
        if (!$post) {
            return $this->sendError(404, 'Không tìm thấy bài viết');
        }

        if (auth()->user()->id !== $post->user_id) {
            return $this->sendError(403, 'Bạn không có quyền xóa bàì viết này');
        }

        $post->delete();

        return $this->sendResponse([], 'Xóa bài viết thành công');
    }

    /**
     *
     * Có nên trả về id không ?
     */
    public function new(Request $request)
    {
        Carbon::setLocale('vi');
        $post = Post::query();
        $user = auth()->user();
        if ($user) {
            $user = $user->load(['blockedAccounts','blockerAccounts']);
            $blocked = $user->blockedAccounts->pluck('id')->toArray(); //lay cac tai khoan bi block
            $blocker = $user->blockerAccounts->pluck('id')->toArray(); //lay cac tai khoan block minh
            $post = $post->unblock($blocked, $blocker);
        }
        $defaultGalleries = $user ? @$user->galleries()->default()->first() : '';
        $posts = $post->approval()
            ->select('id', 'title', 'image', 'share', 'user_id', 'post_uuid', 'created_at', 'like', 'heart', 'wow', 'haha', 'sad', 'angry','thumbnail')
            ->orderBy('approved_at', 'desc')
            ->with(['user:id,avatar,name,user_uuid','comments','comments.user:id,avatar,name'])
            ->with('postReactions')
            ->withCount('comments as total_comments')
            ->paginate()
            ->through(function ($post,$key) use ($user,$defaultGalleries) {
                $post->total_reactions = $post->like + $post->heart + $post->haha + $post->wow + $post->sad + $post->angry;
                $post->lastest_comment = $post->comments_count > 1 ? $post->comments->take(2) : [];
                $post['time'] = $post->created_at->diffForHumans();
                $post['user_action'] = @$post->postReactions->where('user_id',$user->id)->first()->react ?? 'none';
                $post['isSaved'] = ($defaultGalleries ? $defaultGalleries->posts()->wherePivot('post_id',$post->id)->first() : '') ? true : false ;
                return $post;
            })->flatten();
        return $this->sendResponse($posts, 'Lấy danh sách post thành công', 'new');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Lấy ra các post có lượng react và comment nhiều nhất trong vòng 24h
     * fixed:
     *       -
     * bug:
     */
    public function hot(Request $request)
    {
        Carbon::setLocale('vi');

        $post = Post::query();

        $user = Auth::user();

        if ($user) {
            $user = $user->load(['blockedAccounts','blockerAccounts']);
            $blocked = $user->blockedAccounts->pluck('id')->toArray(); //get blocked account
            $blocker = $user->blockerAccounts->pluck('id')->toArray(); //get accounts that blocked this account
            $post = $post->unblock($blocked, $blocker);
        }
        $defaultGalleries = $user ? @$user->galleries()->default()->first() : '';
        $posts = $post->withoutGlobalScope('newest_post')
            ->approval()
            ->select('id', 'title', 'image', 'share', 'user_id', 'post_uuid', 'created_at', 'like', 'heart', 'wow', 'haha', 'sad', 'angry','thumbnail')
//            ->where('approved_at', '>=', now()->subDays(1)->format('Y-m-d H:i:s'))
            ->with(['user:id,name,avatar,email,user_uuid'])
            ->with('postReactions')
            ->withCount('comments as total_comments')
            ->paginate()->through(function ($post,$key) use ($user,$defaultGalleries) {
                $post['total_reactions'] = $post->like + $post->heart + $post->haha + $post->wow + $post->sad + $post->angry;
                $post['time'] = $post->created_at->diffForHumans();
                $post['user_action'] = @$post->postReactions->where('user_id',$user->id)->first()->react ?? 'none';
                $post['isSaved'] = ($defaultGalleries ? $defaultGalleries->posts()->wherePivot('post_id',$post->id)->first() : '') ? true : false;
                return $post;
            })->sortByDesc(function ($post) {
                $rank = $post->comments->where("created_at", ">", Carbon::now()->subHours(24))->count() + $post->postReactions->where("approved_at", ">", Carbon::now()->subHours(24))->count();
                $post['rank'] = $rank;
                return $rank;
            })->flatten();
        return $this->sendResponse($posts, 'Lấy danh sách post thành công', 'hot');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Lấy ra các post có lượng react và comment nhiều nhất trong vòng 1 tuần
     */
    public function top(Request $request)
    {
        Carbon::setLocale('vi');

        $post = Post::query();

        $user = auth()->user();

        $savedPost = [];
        if ($user) {
            $user = $user->load(['blockedAccounts','blockerAccounts']);
            $blocked = $user->blockedAccounts->pluck('id')->toArray(); //lay cac tai khoan bi block
            $blocker = $user->blockerAccounts->pluck('id')->toArray(); //lay cac tai khoan block minh
            $post = $post->unblock($blocked, $blocker);
            $savedPost = $user->savedPost()->pluck('id')->toArray(); //get saved posts
        }

        $posts = $post->getTopPost($savedPost ?? []);

        return $this->sendResponse($posts, 'Lấy danh sách post thành công', 'top');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     *
     */
    public function edit(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => 'Không tìm thấy id bài viết',
        ]);

        if ($validate->fails()) {
            return $this->response($validate->errors(), 404, $validate->errors()->first());
        }

        $post = Post::where('post_uuid', $request->post_id)->first();
        if (!$post) {
            return $this->sendError(404, 'Không tìm thấy bài viết');
        }

        if (auth()->user()->id !== $post->user_id) {
            return $this->sendError(403, 'Bạn không có quyền xóa bàì viết này');
        }

        $post->title = $request->title;

        return $this->sendResponse($post, 'Cập nhật bài viết thành công');
    }

    /**
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function termOfUse()
    {
        $myfile = fopen(base_path("term.txt"), "r") or die("Unable to open file!");
        $term = fread($myfile, filesize("/home/vagrant/code/fun/term.txt"));
        fclose($myfile);
        return $this->sendResponse($term, 'Lấy dữ liệu  thành công');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(Request $request)
    {
        if (!$request->post_uuid) {
            return $this->sendError(403, 'Thiếu dữ liệu');
        }

        if (!$request->report) {
            return $this->sendError(403, 'Vui lòng chọn nội dung report');
        }

        $post = Post::where('post_uuid', $request->post_uuid)->first();
        if (!$post) {
            return $this->sendError(404, 'Không tìm thấy bài viết');
        }

        $reports = explode(',', $request->reports);

        $reports = array_unique($reports);

        foreach ($reports as $report) {
            if ($reportReason = Report::find($report)) {
                $post->reports()->attach($reportReason->id);
            }
        }

        $post->status = Post::REPORT;

        $post->save();

        return $this->sendResponse($post, 'Report bài viết thành công');
    }

    /**
     * @param $post
     * @param $user
     * @return void
     */
    private function sendLikeNotify($post, $user)
    {
        $reaction = $this->getCache("doanxem:reaction_of_post:{$post->id}");
        if (!$reaction) {
            $reaction = getTotalReaction($post) - 1;
        }

        $reaction = $reaction + 1;
        $this->setCache("doanxem:reaction_of_post:{$post->id}", getTotalReaction($post));

    }

    /** save Post into user gallery
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePost(Request $request)
    {
        $rules = [
            'post_id' => 'required|exists:posts,id',
            'action' => 'required|in:save,unsave'
        ];

        $message = [
            'post_id.required' => 'Thiếu post_id',
            'post_id.exists' => 'Bài post không tồn tại',
            'action.required' => 'Thiếu action kìa',
        ];

        $validate = Validator::make($request->all(), $rules, $message);

        $errors = '';
        $listError = $validate->errors()->toArray();
        foreach ($listError as $error) {
            end($listError) == $error ? $errors .= $error[0] : $errors .= $error[0] . ',';
        }

        if ($validate->fails()) {
            return $this->sendError(400, $listError);
        }

        //at present, the post will be saved by default gallery
        $user = auth()->user();
        $defaultGallery = $user->galleries()->default()->first();
        if (!$defaultGallery) {
            $defaultGallery = Gallery::create([
                'user_id' => $user->id,
                'name' => 'default',
            ]);
        }

        try {
            $checkPost = $defaultGallery->posts()->wherePivot('post_id', $request->post_id);
            if ($checkPost->first()) {
                if ($request->action === 'unsave') {
                    $checkPost->detach();
                    return $this->sendResponse([], 'Bỏ lưu bài viết thành công');
                }
                return $this->sendResponse([], 'Bài viết này đã được lưu rồi');
            } else {
                if ($request->action === 'save') {
                    $defaultGallery->posts()->attach($request->post_id);
                    return $this->sendResponse([], 'Lưu bài viết thành công');
                }
                return $this->sendResponse([], 'Bài viết đã lưu đâu');
            }
        } catch (\Exception $e) {
            return $this->sendError(400, 'Đã có lỗi xảy ra, vui lòng thử lại');
        }

    }
}
