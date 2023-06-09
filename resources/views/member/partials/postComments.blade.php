<div class="new-comment" style="display: block;">
                                    <form method="post" id="commentForm" action="{{ route('post.comment', $post->post_uuid) }}"
                                          onsubmit="{{auth()->user() == null ? "redirectToLogin('". route('login') ."')" : "sendComment('". csrf_token() . "','" . route('post.comment',$post->post_uuid)."','". $post->post_uuid."')"}}">
                                        @csrf
                                        <input type="text" placeholder="write comment" name="content" id="commentInput" class="grid">
                                        <button type="submit"><i class="icofont-paper-plane"></i></button>
                                    </form>
    <div class="comments-area">
                <ul id="comments-{{ $post->post_uuid }}" style="height: 40vh;overflow-y: scroll;">
                    @foreach ( $comments as $comment)
                        <li class="shadow-none bg-light rounded pt-1 pl-1">
                            <figure><img alt="" src="{{ $comment->user->avatar }}"></figure>
                            <div class="commenter">
                                <h5><a title="" href="#">{{ $comment->user->name }}</a></h5>
                                <span>{{--2 hours ago --}}</span>
                                <p>
                                    {{ $comment->content }}
                                </p>
                            </div>
                            <div class="m-1">
                                <a class="m-1" onclick="handleCommentsReact('/member/posts/{{ $post->post_uuid }}/react-comments/{{ $comment->id }}/like','{{ csrf_token() }}','like')" title="Like"><i class="icofont-thumbs-up"></i></a>
                                <a class="m-1" onclick="handleCommentsReact('/member/posts/{{ $post->post_uuid }}/react-comments/{{ $comment->id }}/dislike','{{ csrf_token() }}','dislike')" title="Dislike"><i class="icofont-thumbs-down"></i></a>
                                <a class="reply-coment m-1" onclick="showReplyForm('{{$post->post_uuid}}','{{ $comment->id }}')"><i class="icofont-reply"></i></a>
                            </div>
                            <div class="reply-block shadow-none bg-light rounded">
                                <ul class="list-group" id="reply-area-{{$post->post_uuid}}-{{ $comment->id }}">

                                </ul>
                            </div>
                            @if($comment->replies->count() == 0)
                                <div></div>
                            @else
                                <div class="load-more-box-{{$post->post_uuid}}-{{$comment->id}}">
                                    <a onclick="loadReplies('{{route('reply.index',['id' => $post->post_uuid,'commentId'=>$comment->id])}}','{{$post->post_uuid}}','{{$comment->id}}')" style="cursor: default">{{ $comment->replies->count() }} Phản hồi</a>
                                </div>
                            @endif
                            <form method="post" id="replyForm-{{$post->post_uuid }}-{{ $comment->id }}"
                                  action="{{ route('post.reply',$post->post_uuid) }}" style="display: none"
                                  onsubmit="{{ auth()->user() == null ? "redirectToLogin('".route('login')."')" : "sendReply('".csrf_token()."','".$comment->id."','" .route('post.reply',$post->post_uuid)."','".$post->post_uuid."')" }}">
                                    <input type="text" name="content">
                            </form>
                        </li>
                    @endforeach
                </ul>
        @if ($comments->hasMorePages())
        <a id="load-more-comments" style="cursor: pointer;" onclick="loadMoreComments('{{ route('comment.loadmore', $post->post_uuid) }}','{{ $post->post_uuid }}')">Xem thêm bình luận</a>
        @endif
    </div>
</div>


