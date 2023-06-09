<?php

namespace App\Http\Controllers\Members;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PostController extends Controller
{
    public function show(Request $request,$id)
    {
        $user = Auth::user();
        $post = Post::with('user:id,user_uuid,name,email,avatar')
            ->withCount('comments as total_comments')
            ->withCount('postReactions')
            ->where('post_uuid', $id)->first();
        $post['user_action'] = @$post->postReactions()->where('user_id',$user->id)->first()->react ?? 'none';

//            ->transform(function($post) use ($user) {
//                $post['user_action'] = @$post->postReactions->where('user_id',$user->id)->first()->react ?? 'none';
//                return $post;
//            })->first();
        if ($post == null) {
            abort(404);
        }
//        return $post;
        return view('member.posts.show',compact('post'));
    }

    public function handleReactions($postId,$react)
    {
        //        // validate reactions
        ////        if ($react != 'like' || $react != 'heart' || $react != 'haha' || $react != 'wow' || $react != 'sad' || $react != 'angry')
        ////        {
        ////            abort(404);
        ////        }
        //        // take out post_uuid and handle reactions from request parameters
        $user = Auth::user();
        $post = Post::where('post_uuid', $postId)->first();
        if (!$user) {
            return $this->sendError(401,'Không có quyền');
        }
        if (!$react) {
            return $this->sendError(403,'Thiếu dữ liệu');
        }
        if (!in_array($react,array('like','heart','haha','sad','wow','angry'))) {
            return $this->sendError(403,'Sai dữ liệu');
        }
        $reaction = $user->postReactions->where('post_id',$post->id)->first();
        if ($reaction == null) {
            $reaction = new PostReaction();
            $reaction->user_id = $user->id;
            $reaction->post_id = $post->id;
            $reaction->react = $react;
            $reaction->share = 0;
            $post->{$react}++;
        } else {
            if ($reaction->react == $react) {
                $reaction->react = 'none';
                if ($post->{$react} > 0) {
                    $post->{$react}--;
                }
            } else {
                if ($post->{$reaction->react}) {
                    $post->{$reaction->react}--;
                }
                $reaction->react = $react;
                $post->{$react}++;
            }
        }
        $reaction->save();
        $post->save();
        $data = $reaction;
        $data->total_reactions = $post->total_interactive;
        $user = $user->only(['user_uuid', 'name', 'email', 'avatar', 'created_at', 'updated_at']);
//        broadcast(new ReactionsUpdate($user,$reactTo))->toOthers();

        return $this->sendResponse($data,'update dữ liệu');
    }
}
