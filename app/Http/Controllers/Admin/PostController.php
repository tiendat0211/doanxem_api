<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function hidePost(Request $request)
    {
        $post = Post::where('post_uuid', $request->get('post_id'))->first();
        $post->status = Post::HIDE;
        $post->save();
        return $this->sendResponse($post->post_uuid,'success');
    }

    public function showPost(Request $request)
    {
        $post = Post::where('post_uuid', $request->get('post_id'))->first();
        $post->status = 'approval';
        $post->approved_at = now()->format('Y-m-d H:i:s');
        $post->save();
        return $this->sendResponse($post->post_uuid,'success');
    }

    public function actionPost(Request $request)
    {
        $request->validate([
            'type' => 'required|in:approval,reject,delete',
            'checked' => 'required|array',
        ], [

        ]);

        $data = $request->only(['type', 'checked']);

        $posts = Post::whereIn('post_uuid', $data['checked']);


        //tam thoi comment
//        if ($posts->get()->count() <> count($data['checked'])) {
//            return $this->sendError(403, 'Sai dữ liệu, vui lòng thử lại');
//        }

        if ($data['type'] === 'delete') {
            Post::destroy($posts->pluck('id')->toArray());
            return $this->sendResponse([], 'Đã xóa ' . count($data['checked']) . ' bài viết thành công');
        }
        $posts->update(['status' => $data['type'], 'approved_at' => now()->format('Y-m-d H:i:s')]);
        return $this->sendResponse([], 'Đã ' .($data['type'] == 'approval' ? 'chấp nhận ' : 'từ chối ') . count($data['checked']) . ' bài viết thành công');
    }

    public function deletePost($uuid)
    {
        $post = Post::with(['comments','file'])->where('post_uuid', $uuid)->first();
        $post->comments()->delete();
        $post->delete();
        return redirect()->back();
    }

    public function showdetailPost($id)
    {
        $page_name ='Chi tiết bài viết';
        $total_post = Post::get()->count();
        $total_user = User::where('role', 'member')->get()->count();
        $total_post_hide = Post::where('status', 'hide')->get()->count();
//        $total_Interactive = Post::first()->totalInteractive;
//        dd($total_Interactive);
        $posts = Post::findOrFail($id);
        $data = [
            'page_name' => $page_name,
            'total_post' => $total_post,
            'total_user' => $total_user,
            'total_post_hide' => $total_post_hide,
//            'total_Interactive' => $total_Interactive,
           'posts'=>$posts,
        ];
        return view('admin.pages.posts.detailpost')->with($data);
    }

}
