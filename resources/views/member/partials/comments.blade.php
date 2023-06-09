@if($comments->currentPage() > $comments->lastPage())

@else
@foreach($comments as $comment)
    <li class="d-flex">
        <div class="commenter-avatar">
            <img src="{{$comment->user->avatar}}" alt="{{$comment->user->name}}">
        </div>
        <div class="commenter-wraper">
            <div class="d-flex commenter-info">
                <p>{{$comment->user->name}}</p>
                <span>{{$comment->time}}</span>
            </div>
            <div class="comment-content">
                <p style="word-break: break-word">
                    {{$comment->content}}
                </p>
            </div>
            <div class="replies-area">
                <img src="{!! asset('/assets/images/buttons/arrow-bend-up-right.svg') !!}" alt="reply">
                <span>Trả lời</span>
                <input class="open-reply-form" type="checkbox">
                <ul class="replies-list" id="replies-{{$post->post_uuid}}-list-{{$comment->id}}">

                </ul>
                <form class="reply-form d-none"
                      onsubmit="sendReply('{{route('post.reply',$post->post_uuid)}}',
                      '{{$post->post_uuid}}',
                      '{{$comment->id}}')"
                >
                    <label>
                        <img @if(auth()->user())
                                 src="{{auth()->user()->avatar}}"
                             alt="{{auth()->user()->name}}"
                             @else
                                 src="{!! asset('/assets/images/default-user.svg') !!}"
                             alt="user"
                            @endif
                        >
                    </label>
                    <div class="comment-input">
                        <input id="replies-{{$post->post_uuid}}-to-{{$comment->id}}" placeholder="Bán gạch cho chủ thớt">
                        <button class="submit-button" type="submit">
                            <img src="{!! asset('/assets/images/buttons/paper-plane.svg') !!}" alt="submit">
                        </button>
                    </div>
                </form>
            </div>
            <div></div>
        </div>
    </li>
@endforeach
@endif
