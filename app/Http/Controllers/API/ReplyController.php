<?php

namespace App\Http\Controllers\API;

use App\Events\CommentAndReply;
use App\Events\ReactionsUpdate;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplyController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('vi');
        if (!($post_uid = $request->post_uuid) || !($comment_id = $request->comment_id)) {
            return $this->sendError(403, 'Thiếu dữ liệu');
        }
        $post = Post::where('post_uuid',$post_uid)->first();
        $comment = Comment::where('id',$comment_id)->first();
        if (!$post||!$comment) {
            return $this->sendError(404,'Không tìm thấy bản ghi vui lòng kiểm tra lại');
        }
        $replies = Comment::select('id','user_id','post_id',
            'commentable_id as comment_id',
            'commentable_type as type',
            'content','upvote','downvote','created_at as time')
            ->with('user:id,user_uuid,name,email,avatar')
            ->where('post_id',$post->id)
            ->where('commentable_id',$comment->id)
            ->where('commentable_type','App\Models\Comment')
            ->orderByDesc('time')
            ->paginate()->through(function ($reply) {
                $reply->time = Carbon::parse($reply->time)->diffForHumans();
                $reply->type = 'reply';
                return $reply;
            })->flatten();
        return $this->sendResponse($replies,'Lấy dữ liệu thành công');
    }
    public function upvote(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return $this->sendError(401,'Lỗi ủy quyền');
        }
        $reply = Comment::with('reactions')->findOrFail($request->reply_id);
//        $reply = Reply::where('id', $request->reply_id)->first();
        $reaction = $reply->reactions;
        if ($reaction == null) {
            $reaction = new CommentReaction();
            $reaction->react = 'upvote';
            $reaction->user_id = $user->id;
            $reaction->comment_id = $reply->id;
            $reply->upvote = $reply->upvote + 1;
        } else {
            if ($reaction->react == 'upvote') {
                $reaction->react = 'none';
                $reply->upvote = $reply->upvote - 1;
            } else if ($reaction->react == 'downvote') {
                $reaction->react = 'upvote';
                $reply->downvote = $reply->downvote - 1;
                $reply->upvote = $reply->upvote + 1;
            } else {
                $reaction->react = 'upvote';
                $reply->upvote = $reply->upvote + 1;
            }
        }
        $reply->save();
        $reaction->save();
//        $data =[
//            'success' => true,
//            'upvote' => $reply->upvote,
//            'downvote' => $reply->downvote,
//            'post_uuid' => $postId,
//            'comment_id' => $commentId,
//            'type' => 'reply'
//        ];
//        ReactionsUpdate::dispatch($data);

        return $this->sendResponse($reaction,'update reaction');
    }

    public function store(Request $request)
    {
        Carbon::setLocale('vi');
        $user = auth()->user();
        if (!$user) {
            return $this->sendError(401,'Đăng nhập lại');
        }
        $comment = Comment::findOrfail($request->comment_id);
        $post =Post::where('post_uuid',$request->post_uuid)->first();

        $reply = new Comment();
        $reply->user()->associate($request->user());
        $reply->post()->associate($post);
        $reply->upvote = 0;
        $reply->downvote = 0;
        $reply->content = $request->get('content');
        $comment->replies()->save($reply);
        $data = [
            'post_uuid' => $post->post_uuid,
            'total_comments' => $post->loadCount('comments')->comments_count,
            'comment_id' => $comment->id,
            'total_replies' => $comment->loadCount('replies')->replies_count,
            'reply_id' => $reply->id,
            'content' => $request->get('content'),
            'time' => Carbon::parse($reply->created_at)->diffForHumans(),
            'type' => 'reply'
        ];
        broadcast(new CommentAndReply($user->only(['user_uuid', 'name', 'email', 'avatar']),$data))->toOthers();
        return $this->sendResponse($data,'OK');
    }

    public function downvote(Request $request)
    {
        $user = User::where('api_token', $request->api_token)->first();
        $reply = Comment::with('reactions')->findOrFail($request->reply_id);
//        $reply = Reply::where('id', $request->reply_id)->first();
        $reaction = $reply->reactions;
        if ($reaction == null) {
            $reaction = new CommentReaction();
            $reaction->react = 'downvote';
            $reaction->comment_id = $reply->id;
            $reaction->user_id = $user->id;
            $reply->downvote = $reply->downvote + 1;
        }else {
            if ($reaction->react == 'downvote') {
                $reaction->react = 'none';
                $reply->downvote = $reply->downvote -1;
            } else if ($reaction->react == 'upvote') {
                $reaction->react = 'downvote';
                $reply->downvote = $reply->downvote+1;
                $reply->upvote = $reply->upvote - 1;
            } else {
                $reaction->react = 'downvote';
                $reply->downvote = $reply->downvote + 1;
            }
        }
        $reply->save();
        $reaction->save();
        return json_encode([
            'upvote' => $reply->upvote,
            'downvote' => $reply->downvote,
        ]);
    }
}
