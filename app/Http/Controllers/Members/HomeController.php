<?php

namespace App\Http\Controllers\Members;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function landing()
    {
        return view('landingpage');
    }

    public function index(Request $request)
    {
        Carbon::setLocale('vi');
        $user =Auth::user();

        $posts = Post::with(['postReactions','user','file'])
            ->withCount('comments as total_comments')
            ->where('status','approval')
            ->orderByDesc('created_at')
            ->paginate(15)->through(function($post,$key) use ($user) {
            $post['time'] = Carbon::parse($post->created_at)->diffForHumans();
            $post['user_action'] = $post->currentReaction($user);
            return $post;
        });
        if($request->ajax()) {
            return  view('member.posts.index', compact('posts'))->render();
        }
        return view('member.homepage');
    }

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
            ->select('id', 'title', 'image', 'share', 'user_id', 'post_uuid', 'created_at',
                    'like', 'heart', 'wow', 'haha', 'sad', 'angry','thumbnail')
            ->orderBy('created_at', 'desc')
            ->with(['user:id,avatar,name,user_uuid','comments','comments.user:id,avatar,name'])
            ->with('postReactions')
            ->withCount('comments as total_comments')
            ->paginate()
            ->through(function ($post,$key) use ($user,$defaultGalleries) {
                $post->lastest_comment = $post->comments_count > 1 ? $post->comments->take(2) : [];
                $post['time'] = $post->created_at->diffForHumans();
                $post['user_action'] = @$post->postReactions->where('user_id',$user->id)->first()->react ?? 'none';
                $post['isSaved'] = ($defaultGalleries ? $defaultGalleries->posts()->wherePivot('post_id',$post->id)->first() : '') ? true : false ;
                return $post;
            })->flatten();
            if($request->ajax()) {
                return  view('member.posts.index', compact('posts'))->render();
            }
        return view('member.homepage');
    }

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
        if($request->ajax()) {
            return  view('member.posts.index', compact('posts'))->render();
        }
        return view('member.homepage');
    }

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
        if($request->ajax()) {
            return  view('member.posts.index', compact('posts'))->render();
        }
        return view('member.homepage');
    }
}
