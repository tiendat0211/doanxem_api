<?php

namespace App\Http\Controllers\API;


use App\Events\CommentAndReply;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Post;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function upvote(Request $request)
    {
        $user = auth()->user();
        $comment = Comment::where('id', $request->comment_id)->first();
        $reaction = $comment->commentReactions->where('comment_id', $comment->id)->first();
        if ($reaction == null) {
            $reaction = new CommentReaction();
            $reaction->user_id = $user->id;
            $reaction->comment_id = $comment->id;
            $reaction->react = 'upvote';
            $comment->upvote = $comment->upvote + 1;
        }else {
            if ($reaction->react == 'upvote') {
                $reaction->react = 'none';
                $comment->upvote = $comment->upvote -1;
            }else if ($reaction->react == 'downvote') {
                $reaction->react = 'upvote';
                $comment->upvote = $comment->upvote+1;
                $comment->downvote = $comment->downvote -1;
            }else {
                $reaction->react = 'upvote';
                $comment->upvote = $comment->upvote + 1;
            }
        }
        $comment->save();
        $reaction->save();
        return json_encode([
            'upvote' => $comment->upvote,
            'downvote' => $comment->downvote,
        ]);
    }

    public function downvote(Request $request)
    {
        $user = auth()->user();
        $comment = Comment::where('id', $request->comment_id)->first();
        $reaction = $comment->commentReactions->where('comment_id', $request->comment_id)->first();
        if ($reaction == null) {
            $reaction = new CommentReaction();
            $reaction->user_id = $user->id;
            $reaction->comment_id = $comment->id;
            $reaction->react = 'downvote';
            $comment->downvote = $comment->downvote + 1;
        }else {
            if ($reaction->react == 'downvote') {
                $reaction->react = 'none';
                $comment->downvote = $comment->downvote -1;
            }else if ($reaction->react == 'upvote') {
                $reaction->react = 'downvote';
                $comment->downvote = $comment->downvote+1;
                $comment->upvote = $comment->upvote -1;
            }else {
                $reaction->react = 'downvote';
                $comment->downvote = $comment->downvote + 1;
            }
        }
        $comment->save();
        $reaction->save();
        return json_encode([
            'upvote' => $comment->upvote,
            'downvote' => $comment->downvote,
        ]);
    }

    public function store(Request $request) {
        Carbon::setLocale('vi');
        $user = auth()->user();
        if (!$request->get('content') || !$request->post_uuid) {
            return $this->sendError(403, 'Thiếu dữ liệu');
        }
        if (!$user) {
            return $this->sendError(401,'KHông tìm thấy người dùng hoặc người dùng không có quyền');
        }
        $post = Post::where('post_uuid', $request->get('post_uuid'))->first();
        if (!$post) {
            return $this->sendError(404, 'Không tìm thấy bài viết');
        }
        $comment = new Comment();
        $comment->upvote = 0;
        $comment->downvote = 0;
        $comment->content = $request->get('content');
        $comment->user()->associate($user);
        $post->comments()->save($comment);
        $comment->time = Carbon::parse($comment->created_at)->diffForHumans();
        $data=[
            'post_uuid' => $post->post_uuid,
            'total_comments' => $post->loadCount('comments')->comments_count,
            'content' => $request->get('content'),
            'comment_id' => $comment->id,
            'time' => $comment->time,
            'type' => 'comment',
        ];
        broadcast(new CommentAndReply($user->only(['user_uuid', 'name', 'email', 'avatar']),$data))->toOthers();
        return $this->sendResponse($comment, 'Đăng comment thành công!');
    }

    public function index(Request $request)
    {
        Carbon::setLocale('vi');
        $post = Post::where('post_uuid', $request->post_uuid)->first();

        if (!$post) {
            return $this->sendError(404, 'Không tìm thấy bài viết');
        }

        $comments = Comment::select('id','post_id','user_id','content','upvote','downvote','created_at as time')
            ->with('user:id,user_uuid,name,avatar,email')
            ->withCount('replies as total_replies')
            ->where('post_id',$post->id)
            ->whereNull('commentable_id')
            ->orderByDesc('time')->paginate()->through(function ($comment) {
                $comment->time = Carbon::parse($comment->time)->diffForHumans();
                $comment->type = 'comment';
                return $comment;
            })->flatten();

        return $this->sendResponse($comments, 'Lấy comment thành công');

    }
}
