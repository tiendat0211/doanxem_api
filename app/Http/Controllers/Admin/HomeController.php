<?php
namespace App\Http\Controllers\Admin;

use App\Events\UserOffline;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $total_post = Post::get()->count();
        $total_user = User::where('role', 'member')->get()->count();
        $total_post_hide = Post::where('status', 'hide')->get()->count();
        $posts = [
            'total_post' => $total_post,
            'total_user' => $total_user,
            'total_post_hide' => $total_post_hide,
        ];
        return view('admin.home')->with($posts);
    }

    public function showActive(Request $request)
    {
        $users = User::with(['posts'])->where('status', 'active')->paginate(25);
        $page_name = 'Danh sách người dùng';
        if($request->ajax()) {
            return [
                'view' => view('admin.components.activatedusers',compact('users'))->render(),
                'title' => $page_name
            ];
        } else {
            $total_post = Post::get()->count();
            $total_user = User::where('role', 'member')->get()->count();
            $total_post_hide = Post::where('status', 'hide')->get()->count();
            return view('admin.pages.users.index')->with([
                'page_name' => $page_name,
                'total_post' => $total_post,
                'total_user' => $total_user,
                'total_post_hide' => $total_post_hide,
                'users' => $users,
            ]);
        }
    }

    public function  showbanned(Request $request)
    {

        $users = User::with('posts')->where('status', 'banned')->paginate(10);
        $page_name = 'Danh sách người dùng bị cấm';
        if($request->ajax()){
            return [
                'view' => view('admin.components.bannedusers',compact('users'))->render(),
                'title' => $page_name
            ];
        } else {
            $total_post = Post::get()->count();
            $total_user = User::where('role', 'member')->get()->count();
            $total_post_hide = Post::where('status', 'deleted')->get()->count();
            return view('admin.pages.users.deleteduser')->with([
                'page_name' => $page_name,
                'total_post' => $total_post,
                'total_user' => $total_user,
                'total_post_hide' => $total_post_hide,
                'users' => $users,
            ]);
        }
    }

    public function showpost(Request $request)
    {
        Carbon::setLocale('vi');
        $page_name ='Tất cả bài viết';
        $posts = Post::with('user')->whereIn('status',['approval','pending'])
            ->orderBy('created_at', 'desc')
            ->take(config('app.max_image_per_page'))
            ->paginate(12)->through(function($post){
                $post['time'] = $post->created_at->diffForHumans();
                return $post;
            });
        if ($request->ajax()) {
            return [
                'view'=>view ('admin.components.posts',compact('posts'))->render(),
                'title' => $page_name
            ];
        } else {
            $total_post = Post::get()->count();
            $total_user = User::where('role', 'member')->get()->count();
            $total_post_hide = Post::where('status', 'hide')->get()->count();
            return view('admin.pages.posts.index')->with([
                'page_name' => $page_name,
                'total_post' => $total_post,
                'total_user' => $total_user,
                'total_post_hide' => $total_post_hide,
                'posts' => $posts
            ]);
        }
    }

    public function pendingPosts(Request $request)
    {
        Carbon::setlocale('vi');
        $posts = Post::with(['user'])->where('status' , 'pending')->orderBy('created_at', 'desc')->paginate(8);
        $page_name ='Bài viết chưa duyệt';
        if ($request->ajax()) {
            return [
                'view' => view('admin.components.pendingposts',compact('posts'))->render(),
                'title' => $page_name
            ];
        } else {
            $total_post = Post::get()->count();
            $total_user = User::where('role', 'member')->get()->count();
            $total_post_hide = Post::where('status', 'hide')->get()->count();
            return view('admin.pages.posts.waitingpost')->with([
                'page_name' => $page_name,
                'total_post' => $total_post,
                'total_user' => $total_user,
                'total_post_hide' => $total_post_hide,
                'posts' => $posts
            ]);
        }
    }

    public function deletedPosts(Request $request)
    {
        Carbon::setLocale('vi');
        $page_name ='Bài viết bị xóa';
        $posts = Post::with('user')->where('status', 'deleted')->paginate();
        if ($request->ajax()) {
            return [
                'view' => view('admin.components.deletedposts',compact('posts'))->render(),
                'title' => $page_name
            ];
        } else {
            $total_post = Post::get()->count();
            $total_user = User::where('role', 'member')->get()->count();
            $total_post_hide = Post::where('status', 'deleted')->get()->count();
            return view('admin.pages.posts.deletedpost')->with([
                'page_name' => $page_name,
                'total_post' => $total_post,
                'total_user' => $total_user,
                'total_post_hide' => $total_post_hide,
                'posts' => $posts
            ]);
        }
    }

    public function hiddenPosts(Request $request)
    {

        $posts = Post::with('user')->where('status', Post::HIDE)->orderBy('created_at', 'desc')->paginate(8);
        $page_name = 'Bài viết bị ẩn';
        if($request->ajax()) {
            return [
                'view' => view('admin.components.hiddenposts',compact('posts'))->render(),
                'title' => $page_name
            ];
        } else {
            $total_post = Post::get()->count();
            $total_user = User::where('role', 'member')->get()->count();
            $total_post_hide = Post::where('status', 'deleted')->get()->count();
            return view('admin.pages.posts.hidepost')->with([
                'page_name' => $page_name,
                'total_post' => $total_post,
                'total_user' => $total_user,
                'total_post_hide' => $total_post_hide,
                'posts' => $posts
            ]);
        }
    }

    public function loadMore(Request $request)
    {

        $posts = Post::orderBy('created_at', 'desc')->get()->forPage($request->page, 12);
        $html = view('admin.partials.showImage', compact('posts'))->render();
        return response()->json(['html' => $html]);
    }

    public function userdelete($id)
    {
        $users = User::findOrFail($id);
        $users->status = 'banned';
        foreach( $users->posts as $postStatus) {
            if ($postStatus->status == 'approved') {
                $postStatus->update(['status'=> 'hide']);
            }
            else if ($postStatus->status == 'new'){
                $postStatus->update(['status'=> 'hide_new']);
            } else if ($postStatus->status == 'hide') {
                $postStatus->update(['status'=> 'hide_hide']);

            }
        }
        foreach( $users->comments as $commentStatus) {
            $commentStatus->update(['status'=> 'hide']);
        }
        foreach( $users->comments as $replyStatus) {
            $replyStatus->update(['status'=> 'hide']);
        }
        $users->save();
        return back();
    }


    public function restore($id)
    {
        $users = User::findOrFail($id);
        $users->status = 'active';
        foreach($users->posts as $postStatus) {
            if ($postStatus->status == 'hide') {
                $postStatus->update(['status'=> 'approved']);
            } else if ($postStatus->status == 'hide_new') {
                $postStatus->update(['status'=> 'new']);
            } else if ($postStatus->status == 'hide_hide') {
                $postStatus->update(['status'=> 'hide']);
            }
        }
        $users->save();
        return back();
    }

    // public function delete($id)
    // {
    //     $posts = Post::where('public_id', $id)->first();
    //     $posts->status = 'hide';
    //     $posts->save();
    //     return back();
    // }
    public function showcomment($id){
        $post = Post::findOrFail($id);
        $comments = Comment::with(['user'])->where('commentable_id',$post->id)->where('commentable_type', 'App\Models\Post')->paginate(5);

        return view('admin.partials.comments',compact('comments'))->render();
    }
    public function destroyComment($id){
        $comment = Comment::find($id);
        if($comment)
        {
            $comment->delete();
        }
        return redirect()->back();
    }

}
