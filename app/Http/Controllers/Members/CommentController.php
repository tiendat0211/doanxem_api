<?php

namespace App\Http\Controllers\Members;

use App\Events\CommentAndReply;
use App\Events\ReactionsUpdate;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($id)
    {
        Carbon::setLocale('vi');
        $user = Auth::user();
        if($user) {
            $user = $user->load('commentReactions');
        }
        $post = Post::where('post_uuid', $id)->first();
        $comments = Comment::with('user')
            ->select('id','user_id','post_id','content','upvote','downvote','created_at as time',
                'commentable_id','commentable_type')
            ->withCount('replies')
            ->where('post_id', $post->id)
            ->whereNull('commentable_id')
            ->orderByDesc('time')
            ->paginate(5)->through(function ($comment) use ($user) {
                $comment->time = Carbon::parse($comment->time)->diffForHumans();
                $comment->user_action =$user ? @$user->commentReactions->where('comment_id',$comment->id)->first()->react : 'none';
                return $comment;
            });
        return [
                'view' => view('member.partials.comments',compact('comments','post'))->render(),
                'isLastPage' => $comments->currentPage() > $comments->lastPage(),
                'lastPage' => $comments->lastpage()
            ];
    }

    public function store(Request $request, $postId)
    {
        Carbon::setLocale('vi');
        $user = Auth::user()->only(['user_uuid', 'name', 'email', 'avatar', 'created_at', 'updated_at']);
        $post = Post::with('comments')->where('post_uuid', $postId)->first();
        if (!$post){
            abort(404);
        }
        $comment = new Comment();
        $comment->content = $request->get('content');
        $comment->upvote = 0;
        $comment->downvote = 0;
        $comment->user()->associate($request->user());
        $post->comments()->save($comment);
        $data = [
            'post_uuid' => $post->post_uuid,
            'total_comments' => $post->loadCount('comments')->comments_count,
            'content' => $request->get('content'),
            'comment_id' => $comment->id,
            'time' => $comment->created_at->diffForHumans(),
            'type' => 'comment',
        ];
        broadcast(new CommentAndReply($user,$data))->toOthers();
        return $this->sendResponse($data,'OK');
    }
    public function loadMore($postId)
    {
        $post = Post::where('post_uuid', $postId)->first();
        $comments = Comment::where('commentable_type','App\Models\Post')->where('commentable_id', $post->id)->orderByDesc('created_at')->paginate(5);
        $isLastPage = $comments->currentPage() >= $comments->lastPage();
        return [
            'view' => view('member.partials.comment',compact('comments','post'))->render(),
            'isLastPage' => $isLastPage
            ];
    }

    public function upvote(Request $request,$postId,$commentId)
    {
        $react = $request->get('react');
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        $post = Post::where('post_uuid',$postId)->first();
        $comment = Comment::findOrFail($commentId);
        $reaction = $user->commentReactions->where('comment_id', $comment->id)->first();
        if (! $post || ! $comment || $react != 'like' || ($user->id != $request->user()->id))
        {
            abort(404);
        }
        if ($reaction == null) {
            $reaction = new CommentReaction();
            $comment->upvote = $comment->upvote+1;
            $reaction->user_id= Auth::user()->id;
            $reaction->comment_id = $commentId;
            $reaction->react = 'upvote';
        } else {
            if ($reaction->react == 'upvote') {
                $comment->upvote = $comment->upvote -1;
                $reaction->react = 'none';
            }
            else if ($reaction->react == 'downvote') {
                $comment->upvote = $comment->upvote+1;
                $comment->downvote = $comment->downvote -1;
                $reaction->react= 'upvote';
            }
            else {
                $comment->upvote++;
                $reaction->react = 'upvote';
            }

        }
        $reaction->save();
        $comment->save();
        $data = [
            'success' => true,
            'upvote' => $comment->upvote,
            'downvote' => $comment->downvote,
            'post_uuid' => $postId,
            'comment_id' => $commentId,
            'type' => 'comment'
        ];
//        broadcast(new ReactionsUpdate($data));
        ReactionsUpdate::dispatch($data);
        return $data;
    }

    public function downvote(Request $request,$postId,$commentId)
    {
        $react = $request->get('react');
        $user = Auth::user()->load('commentReactions');
        if (!$user) return redirect()->route('login');
        $post = Post::where('post_uuid',$postId)->first();
        $comment = Comment::findOrFail($commentId);
        $reaction = $user->commentReactions->where('comment_id', $comment->id)->first();
        if (! $post || ! $comment || $react != 'dislike' || ($user->id != $request->user()->id))
        {
            abort(404);
        }
        if ($reaction == null) {
            $reaction = new CommentReaction();
            $comment->downvote = $comment->downvote +1;
            $reaction->user_id= $user->id;
            $reaction->comment_id = $commentId;
            $reaction->react = 'downvote';

        } else {
            if ($reaction->react == 'upvote') {
                $comment->upvote = $comment->upvote-1;
                $comment->downvote++;
                $reaction->react = 'downvote';
            }
            else if ($reaction->react == 'downvote') {
                $comment->downvote--;
                $reaction->react= 'none';
            }
            else {
                $comment->downvote++;
                $reaction->react = 'downvote';
            }
        }
        $reaction->save();
        $comment->save();
        $data =[
            'success' => true,
            'upvote' => $comment->upvote,
            'downvote' => $comment->downvote,
            'post_uuid' => $postId,
            'comment_id' => $commentId,
            'type' => 'comment'
        ];
//        broadcast(new ReactionsUpdate($data));
        ReactionsUpdate::dispatch($data);
        return $data;
    }
}
