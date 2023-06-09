@foreach($replies as $reply)
<li class="d-flex">
    <div class="replier-avatar">
        <img src="{{$reply->user->avatar}}">
    </div>
    <div class="replier-details">
        <div class="commenter-info d-flex">
            <p>{{$reply->user->name}}</p>
            <span>{{ $reply->time }}</span>
        </div>
        <div class="comment-content">
            {{$reply->content}}
        </div>
        <div class="replies-area">
            <img src="{!! asset('/assets/images/buttons/arrow-bend-up-right.svg') !!}" alt="reply">
            <span>Trả lời</span>
        </div>
    </div>
</li>
@endforeach
