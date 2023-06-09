<?php

namespace App\Http\Controllers\Members;

use App\Events\CommentAndReply;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    /**
     * Store reply
     * @param Request $request
     * @param $post_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request,$post_id)
    {
        Carbon::setLocale('vi');
        $user = Auth::user()->only(['user_uuid', 'name', 'email', 'avatar', 'created_at', 'updated_at']);
        $comment = Comment::with(['commentable'])->findOrfail($request->comment_id);
        $post = Post::where('post_uuid',$post_id)->first();

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
            'content' => $request->get('content'),
            'comment_id' => $comment->id,
            'total_replies' => $comment->loadCount('replies')->replies_count ,
            'reply_id' => $reply->id,
            'time' => Carbon::parse($reply->created_at)->diffForHumans(),
            'type' => 'reply'
        ];
        broadcast(new CommentAndReply($user,$data))->toOthers();

        return $this->sendResponse($data,'OK');
    }

    /**
     * show paginated replies
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request,$postId,$commentId)
    {
        Carbon::setLocale('vi');
        $user=Auth::user();
        if($user) {
            $user = $user->load('commentReactions');
        }
        $post = Post::where('post_uuid',$postId)->first();
        $comment = Comment::findOrFail($commentId);
        $replies = Comment::with('user')
            ->where('commentable_id',$comment->id)
            ->where('commentable_type','App\Models\Comment')
            ->orderByDesc('created_at')
            ->select('id','user_id','post_id',
                'commentable_id as comment_id',
                'content','created_at as time','upvote','downvote')
            ->paginate(3)->transform(function ($reply) use ($user) {
                $reply->time = Carbon::parse($reply->time)->diffForHumans();
                $reply->user_action = @$user->commentReactions->where('comment_id',$reply->id)->first()->react ?? 'none';
                return $reply;
            });
        return [
            'view' => view('member.partials.replies',compact('replies','post'))->render(),
        ];
    }
}
