@foreach($comments as $comment)
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
            <a class="m-1 reply-coment" onclick="showReplyForm('{{$post->post_uuid}}','{{ $comment->id }}')" ><i class="icofont-reply"></i></a>
        </div>
        <div class="reply-block">
            <ul class="list-group" id="reply-area-{{$post->post_uuid}}-{{ $comment->id }}">

            </ul>
        </div>
        @if($comment->replies->count() == 0)
            <div></div>
        @else
            <div>
                <a onclick="loadReplies('{{route('reply.index',['id' => $post->post_uuid,'commentId'=>$comment->id])}}','{{$post->post_uuid}}','{{$comment->id}}')"
                   style="cursor: default">
                    {{ $comment->replies->count() }} Phản hồi
                </a>
            </div>
        @endif
            <form method="post" id="replyForm-{{ $post->post_uuid }}-{{ $comment->id }}" action="{{ route('post.reply',$post->post_uuid) }}" style="display: none" onsubmit="sendReply('{{ csrf_token() }}','{{ $comment->id }}','{{ route('post.reply',$post->post_uuid) }}','{{ $post->post_uuid }}')">
                @csrf
                <div class="row">
                    <input type="text" placeholder="Reply to {{ $comment->user->name }}" name="content" id="replyInput-{{ $post->post_uuid }}">
                </div>
            </form>
    </li>

@endforeach
