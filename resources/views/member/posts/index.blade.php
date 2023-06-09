@foreach($posts as $post)
    <div class="post-item">
        {{-- author info --}}
        <div class="d-inline-flex justify-content-between w-100">
            <div class="d-inline-flex">
                <img class="author" src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}">
                <div>
                    <p class="m-0 author-name">
                        {{ $post->user->name }}
                    </p>
                    <span class="post-time">
                    {{ $post->time }}
                </span>
                </div>
            </div>
            {{-- tool bar --}}
{{--            <div class="position-relative tool-box">--}}
{{--                <img class="position-relative left-center"--}}
{{--                    src="{!! asset('/assets/images/buttons/threedots.svg') !!}" alt="tool-bar">--}}
{{--                <input class="check-toolbar" type="checkbox">--}}
{{--                <div class="toolbar position-absolute d-none">--}}
{{--                    <div onclick=""--}}
{{--                         class="tool-item">--}}
{{--                        <img class="m-3"--}}
{{--                            src="{!! asset('/assets/images/buttons/warning.svg') !!}" alt="report">--}}
{{--                        Báo cáo bài viết--}}
{{--                    </div>--}}
{{--                    <div onclick=""--}}
{{--                         class="tool-item">--}}
{{--                        <img class="m-3"--}}
{{--                            src="{!! asset('/assets/images/buttons/UserMinus.svg') !!}" alt="block-user">--}}
{{--                        Chặn người dùng này--}}
{{--                    </div>--}}
{{--                    <div onclick=""--}}
{{--                         class="tool-item">--}}
{{--                        <img class="m-3"--}}
{{--                            src="{!! asset('/assets/images/buttons/EyeClosed.svg') !!}" alt="hide-post">--}}
{{--                        Ẩn bài viết này--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        {{-- post detail --}}
        <div>
            <div class="break-line"></div>
            <div class="post-title mb-3">
                {{-- post title --}}
                {{ $post->title }}
            </div>
            <div class="d-flex justify-content-center post-media">
                @if(detect_extension_post($post->image) == 'video')
                    <video
                        class="w-100 mh-70"
                        src="{{ $post->image }}"
                        controls poster="{{ $post->thumbnail ?? '' }}">
                    </video>
                @else
                    <img src="{{ $post->image }}"
                        alt="{{$post->title}}"
                         class="d-flex justify-content-center w-100"
                    >
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex">
                <div class="mr-3 custom-text position-relative hover-react" >
                    <img id="react-to-{{$post->post_uuid}}"
                         class="square-icon-size"
                         @if ($post->user_action !== 'none')
                             @if($post->user_action == 'like')
                                 src="{!! asset("/assets/images/emojis/like.svg") !!}"
                            @else
                            src="{!! asset("/assets/images/emojis/$post->user_action.gif") !!}"
                            @endif
                         @else
                        src="{!! asset('/assets/images/buttons/thumbsup.svg') !!}"
                         @endif
                        alt="reaction">
                    <input class="check-react" type="checkbox">
                    <div class="reacts d-none">
                        <img
                            onclick="handlePostReactions('{{ route('post.react',[$post->post_uuid,$reaction='like']) }}'
                        ,'{{$post->post_uuid}}')"
                             class="reactions"
                            src="{!! asset('/assets/images/emojis/like.svg') !!}" alt="like">
                        <img
                            onclick="handlePostReactions('{{ route('post.react',[$post->post_uuid,$reaction='heart']) }}'
                        ,'{{$post->post_uuid}}')"
                             class="reactions"
                            src="{!! asset('/assets/images/emojis/heart.gif') !!}" alt="heart">
                        <img
                            onclick="handlePostReactions('{{ route('post.react',[$post->post_uuid,$reaction='haha']) }}'
                        ,'{{$post->post_uuid}}')"
                            class="reactions"
                            src="{!! asset('/assets/images/emojis/haha.gif') !!}" alt="haha">
                        <img
                            onclick="handlePostReactions('{{ route('post.react',[$post->post_uuid,$reaction='haha']) }}'
                        ,'{{$post->post_uuid}}')"
                             class="reactions"
                            src="{!! asset('/assets/images/emojis/wow.gif') !!}" alt="wow">
                        <img
                            onclick="handlePostReactions('{{ route('post.react',[$post->post_uuid,$reaction='sad']) }}'
                        ,'{{$post->post_uuid}}')"
                             class="reactions"
                            src="{!! asset('/assets/images/emojis/sad.gif') !!}" alt="sad">
                        <img
                            onclick="handlePostReactions('{{ route('post.react',[$post->post_uuid,$reaction='angry']) }}'
                        ,'{{$post->post_uuid}}')"
                             class="reactions"
                            src="{!! asset('/assets/images/emojis/angry.gif') !!}" alt="angry">
                    </div>
                    <span id="updateTotalReactionsOf-{{$post->post_uuid}}">{{ $post->total_interactive }}</span>
                </div>
                <a href="{{ route('post.detail',$post->post_uuid) }}"
                   class="mr-3 custom-text">
                    <img class="square-icon-size"
                        src="{!! asset('/assets/images/buttons/comment.svg') !!}"
                        alt="comments">
                    {{ $post->total_comments }}
                </a>
{{--                <a href=" share button " class="custom-text">--}}
{{--                    <img class="square-icon-size"--}}
{{--                        src="{!! asset('/assets/images/buttons/speaker.svg') !!}"--}}
{{--                        alt="share">--}}
{{--                    Chia sẻ--}}
{{--                </a>--}}
            </div>
{{--            <a href="--}}{{-- saved post --}}{{--">--}}
{{--                <img class="rectangle-icon-size ico-disabled"--}}
{{--                    src="{!! asset('/assets/images/buttons/saved.svg') !!}"--}}
{{--                    alt="saved-post">--}}
{{--            </a>--}}
        </div>
    </div>
@endforeach
