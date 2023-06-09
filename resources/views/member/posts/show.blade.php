@extends('member.layouts.app')
@pushonce('meta')
    <meta name="description" content="{{$post->title}}" />
    <meta name="keywords" content="{{$post->uuid}}, {{$post->title}}" />
    <meta property="og:url" content="https://doanxem.com/posts/{{$post->post_uuid}}" />
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:type" content="website" />
    @if (!$post->thumbnail)
        <meta property="og:image" content="{{ $post->image }}" />
    @else
        <meta property="og:image" content="{{ $post->thumbnail }}" />
    @endif
    <meta property="og:locale" content="vi" />
    <title>{{$post->title}}</title>
@endpushonce
@pushonce('css')
    <style>
        .responsive-div {
            position: relative;
            left: 50%;
            transform: translate(-50%);
            margin-top: 10px;
            margin-bottom: 2rem;
        }
        .wrapper {
            padding: 0 2rem 0 2rem;
            position: relative;
        }
        .chick {
            top: 6px;
            position: relative;
        }
        img[alt="right"] {
            position: absolute;
            bottom: -1%;
            left: -1%;
        }
        img[alt="left"] {
            position: absolute;
            bottom: -1%;
            left: 17%;
        }
        .post-details {
            background-color: white;
            height: 100%;
            padding: 1rem 24px;
            position: relative;
        }
        .author {
            display: flex;
        }
        .author-info {
            font-family: Averta-PE-Semibold,sans-serif;
            margin-left: 1rem;
        }
        .author > img {
            width: 40px;
            height: 40px;
        }
        .author-info > p {
            font-size: 14px;
            margin: 0;
            font-weight: 700;
            line-height: 20px;
            color: #0B2347;
        }
        .author-info > span {
            font-size: 12px;
            font-weight: 400;
            line-height: 18px;
            color: #527898;
            font-family: Averta-PE-Semibold,sans-serif;
        }
        .tool-box {
            width: 40px;
            height: 40px;
        }
        .tool-box > img {
            top: 50%;
            right: 0;
            transform: translate(-50%,-50%);
        }
        .check-toolbar {
            z-index: 5;
            width: 100%;
            height: 100%;
            opacity: 0;
        }
        input.check-toolbar:checked ~ .toolbar {
            top: 100%;
            display: block !important;
            width: 275px;
            height: 184px;
            right: 0;
            box-shadow: 0px 2px 10px  rgba(32, 49, 94, 0.2);
            border-radius: 10px;
            background-color: white;
        }
        .tool-item {
            border-radius: 10px;
            width: 100%;
            height: 33%;
            backdrop-filter: blur(14px);
            background-color: white;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            color: #3D4953;
            cursor: pointer;
        }
        .tool-item:hover {
            color: #0d6efd;
            box-shadow: 0px 2px 10px  rgba(32, 49, 94, 0.2);
        }
        .horizon-break-line {
            height: 1px;
            background-color: #ECECEC;
            margin: 8px 0;
        }
        .title {
            font-weight: 400;
            color: #4A4A4A;
            margin-bottom: 1rem;
            font-family: Averta-PE-Regular,sans-serif;
        }
        .mw-100 {
            width: 100%;
        }
        .check-react {
            position: absolute;
            width: 20px;
            height: 20px;
            opacity: 0;
            cursor: pointer;
            z-index: 5;
        }
        /*input.check-react:checked ~ .reacts {*/
        /*    background: #FFFFFF;*/
        /*    box-shadow: 0px 13px 13px rgba(0, 0, 0, 0.15);*/
        /*    border-radius: 60px;*/
        /*    width: 212px;*/
        /*    height: 40px;*/
        /*    display: flex !important;*/
        /*    justify-content: space-evenly;*/
        /*    align-items: center;*/
        /*    position: absolute;*/
        /*    bottom: 100%;*/
        /*    z-index: 2;*/
        /*}*/
        .react-tool:hover input.check-react ~ .reacts {
            background: #FFFFFF;
            box-shadow: 0px 13px 13px rgba(0, 0, 0, 0.15);
            border-radius: 60px;
            width: 212px;
            height: 40px;
            display: flex !important;
            justify-content: space-evenly;
            align-items: center;
            position: absolute;
            bottom: 100%;
            z-index: 2;
        }
        .square-icon-size {
            width: 20px;
            height: 20px;
            margin-right: .5rem;
        }
        a {
            color: #3D4953;
        }
        .react-tool {
            color: #3D4953;
        }
        .comments-box {
            margin-top: 1rem;
        }
        form#my-comment {
            display: flex;
        }
        form#my-comment > label img {
            border-radius: 50%;
            height: 43px;
            width: 43px;
            object-fit: cover;
        }
        .comment-input {
            height: 43px;
            width: calc(100% - 43px - 16px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #F2F1F1;
            border-radius: 10px;
            background-color: #FAFAFA;
            margin-left: 1rem;
            padding: 0 14px;
        }
        .comment-input > input {
            outline: none;
            border: none;
            background-color: #FAFAFA;
            color: #7B7B7B;
            width: calc(100% - 14px - 14px - 20px);
        }
        .comments-list {
            margin: 2.4rem 0 0 0;
            padding: 0;
        }
        .commenter-wraper {
            width: calc(100% - 3.4rem);
        }
        .commenter-avatar {
            width: 43px;
            height: 43px;
            margin-right: 1rem;
        }
        .commenter-avatar > img {
            width: 43px;
            height: 43px;
            border-radius: 50%;
            object-fit: cover;
        }
        .commenter-info > p {
            margin: 0 24px 0 0;
            font-size: 14px;
            line-height: 20px;
            color: #0B2347;
            font-weight: 600;
        }
        .commenter-info > span {
            font-size: 14px;
            line-height: 20px;
            color: #ADADAD;
        }
        .comment-content {
            margin-top: 4px;
            font-weight: 400;
            font-size: 14px;
            line-height: 20px;
            color: #4A4A4A;
        }
        .replies-area {
            position: relative;
        }
        .replies-area > span {
            color: #ADADAD;
            font-size: 12px;
            font-weight: 400;
            line-height: 18px;
        }
        .replies-area > input {
            width: 52px;
            position: absolute;
            height: 22px;
            top: 0;
            left: 0;
            opacity: 0;
            z-index: 5;
            cursor: pointer;
        }
        .replies-area > input.open-reply-form:checked ~ form.reply-form {
            display: flex !important;
        }
        .reply-form > label img {
            border-radius: 50%;
            height: 32px;
            width: 32px;
            object-fit: cover;
        }
        .submit-button {
            border: none;
            background-color: #FAFAFA;
        }
        .submit-button > img {
            filter: invert(31%) sepia(72%) saturate(4355%) hue-rotate(204deg) brightness(105%) contrast(99%);
        }
        .replies-list {
            margin: 1rem 0;
        }
        .replier-avatar {
            width: 32px;
            height: 32px;
            margin-right: 1rem;
        }
        .replier-avatar > img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        ul.replies-list > li {
            list-style-type: none;
        }
        .mh-70 {
            max-height: 70vh;
        }
        .media {
            position: relative;
            width: calc(100% + 48px);
            transform: translateX(-24px);
            background-color: black;
        }
    </style>
@endpushonce
@section('content')
    <div class="container-fluid">
        <div class="responsive-div col-lg-4 col-md-6 col-12">
            <div class="wrapper">
                <div class="chick">
                    <img src="{!! asset('/assets/images/chick/intro-chick.svg') !!}" alt="">
                </div>

            </div>
            <div class="post-details">
                <div class="head-card d-flex justify-content-between">
                    <div class="author">
                        <img src="{{$post->user->avatar}}" alt="Avatar">
                        <div class="author-info">
                            <p>{{$post->user->name}}</p>
                            <span>{{$post->time}}</span>
                        </div>
                    </div>
                    <div class="position-relative tool-box">
                        <img class="position-absolute"
                             src="{!! asset('/assets/images/buttons/threedots.svg') !!}" alt="tool-bar">
                        <input class="check-toolbar position-absolute" type="checkbox">
                        <div class="toolbar position-absolute d-none">
                            <div onclick=""
                                 class="tool-item">
                                <img class="m-3"
                                     src="{!! asset('/assets/images/buttons/warning.svg') !!}" alt="report">
                                Báo cáo bài viết
                            </div>
                            <div onclick=""
                                 class="tool-item">
                                <img class="m-3"
                                     src="{!! asset('/assets/images/buttons/UserMinus.svg') !!}" alt="block-user">
                                Chặn người dùng này
                            </div>
                            <div onclick=""
                                 class="tool-item">
                                <img class="m-3"
                                     src="{!! asset('/assets/images/buttons/EyeClosed.svg') !!}" alt="hide-post">
                                Ẩn bài viết này
                            </div>
                        </div>
                    </div>
                </div>
                <div class="horizon-break-line"></div>
                <div class="body-card position-relative">
                    <div class="title">{{$post->title}}</div>
                    <div class="media">
                        @if(detect_extension_post($post->image) == 'video')
                            <video
                                class="mw-100 mh-70"
                                src="{{ $post->image }}"
                                controls poster="{{ $post->thumbnail ?? '' }}">
                            </video>
                        @else
                            <img src="{{ $post->image }}"
                                 alt="{{$post->title}}"
                                 class="mw-100"
                            >
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="w-50 d-flex position-relative">
                        <div class="d-flex position-relative col-4 react-tool">
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
                            {{ $post->total_interactive }}
                        </div>
                        <a class="col-4" href="{{ route('post.detail',$post->post_uuid) }}"
                           class="mr-3 custom-text">
                            <img class="square-icon-size"
                                 src="{!! asset('/assets/images/buttons/comment.svg') !!}"
                                 alt="comments">
                            <span id="totalCommentsOf-{{$post->post_uuid}}">{{ $post->total_comments }}</span>
                        </a>
{{--                        <a class="col-4" href=" share button " class="custom-text">--}}
{{--                            <img class="square-icon-size"--}}
{{--                                 src="{!! asset('/assets/images/buttons/speaker.svg') !!}"--}}
{{--                                 alt="share">--}}
{{--                            Chia sẻ--}}
{{--                        </a>--}}
                    </div>
                    <a href="{{-- --}}">
                        <img class="rectangle-icon-size ico-disabled"
                             src="{!! asset('/assets/images/buttons/saved.svg') !!}"
                             alt="saved-post">
                    </a>
                </div>
                <div class="comments-box">
                    <div class="comment-form">
                        <form method="post"
                              action="/member/posts/{{$post->post_uuid}}/comments"
                              onsubmit="sendComment('/member/posts/{{$post->post_uuid}}/comments')"
                            id="my-comment">
                            <label for="commentInput">
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
                                <input id="commentInput" placeholder="Bán gạch cho chủ thớt">
                                <button class="submit-button" type="submit">
                                    <img src="{!! asset('/assets/images/buttons/paper-plane.svg') !!}" alt="submit">
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="comments-area">
                        <ul class="comments-list">

                        </ul>
                        <div class="auto-load text-center">
                            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                        <path fill="#000" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                        </path>
                                        </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@pushonce('script')
    <script>
        let page= 1;
        let user = '{{auth()->user()}}';
        let csrf = $('meta[name="csrf-token"]').attr("content");
        let post_uuid = '{{$post->post_uuid}}';
        let channel = `post.${post_uuid}`;
        let commentsCount = $('#totalCommentsOf-{{$post->post_uuid}}');
        requestCommentList(page)
        $('div.container-fluid').scroll(function () {
            if ($(window).scrollTop() >= $(document).height()- $(window).height()-1) {
                page++;
                requestCommentList(page)
            }
        });
        function requestCommentList(page) {
            let comments_area = $('.comments-area > ul');
            let autoLoad = $('.auto-load');
            $.ajax({
                url: '{{ route('post.comment.index', $post->post_uuid) }}' + '?page=' + page,
                method: 'get',
                beforeSend: function (request) {
                    autoLoad.show();
                }
            }).done(response => {
                if (!response) {
                    autoLoad.hide();
                    // $('.comments-area > div').html(`<p class="text-center mb-0 mt-2">Không còn comments để hiển thị</p>`);
                    return;
                }
                if (response.isLastPage) {
                    $('.scroll-down').attr('onclick',`requestCommentList(${response.lastPage + 1})`)
                    autoLoad.hide();
                    return;
                }

                autoLoad.hide();
                comments_area.append(response.view);
            }).fail(err => {
                console.log(err)
            })
        }
        function redirectTo(url) {
            window.location.href= url;
        }
        function randomString(length) {
            const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const charactersLength = characters.length;
            for(let i=0;i<length;i++) {
                result +=characters.charAt(Math.floor(Math.random()*charactersLength));
            }
            return result;
        }
        function handleReactions(url,post_id,react) {
            if (user === '') {
                return redirectTo('{{ route('login') }}');
            }

            $.ajax({
                url:  url,
                type: "get",
            })
                .done(response=>{
                    if (!response) return;
                    if (response.data.react === 'none') {
                        $('#react-to-' + post_id).html(`
                        <i class="icofont-like"></i>
                    `);
                    } else {
                        $('#react-to-' + post_id).html(`
                            <div class="${response.data.react}"></div>
                        `);
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
        function handlePostReactions(url,post_uuid) {
            if (user === '') return redirectTo('/login');
            let user_action = $('#react-to-'+post_uuid);
            let totalReactions = $('#updateTotalReactionsOf-' + post_uuid);
            $.ajax({
                url,
                type: "post",
                beforeSend: function (request) {
                    request.setRequestHeader('X-CSRF-TOKEN',csrf)
                }
            }).done(response => {
                if (!response) return;
                if (response.data.react === 'none') {
                    user_action.attr('src','{!! asset('/assets/images/buttons/thumbsup.svg') !!}');
                } else {
                    if (response.data.react === 'like') {
                        user_action.attr('src',`/assets/images/emojis/like.svg`);
                    } else {
                        user_action.attr('src',`/assets/images/emojis/${response.data.react}.gif`);
                    }
                }
                totalReactions.text(`${response.data.total_reactions}`);
            }).fail(error => {
                console.log('Server error occured')
            });
        };

        function handleCommentsReact(url,react) {
            if (user === '') {
                return redirectTo('{{ route('login') }}')
            }
            let comment_id = url.split('/')[5];
            let iconUp= $(`.react-to-${comment_id} i.icofont-arrow-up`);
            let iconDown= $(`.react-to-${comment_id} i.icofont-arrow-down`);
            if (react === 'like') {
                if (iconUp.hasClass('change-color')) {
                    iconUp.removeClass('change-color');
                } else if (iconDown.hasClass('change-color')) {
                    iconDown.removeClass('change-color');
                    iconUp.addClass('change-color');
                } else {
                    iconUp.addClass('change-color');
                }
            }
            if (react === 'dislike') {
                if (iconDown.hasClass('change-color')) {
                    iconDown.removeClass('change-color');
                } else if (iconUp.hasClass('change-color')){
                    iconUp.removeClass('change-color');
                    iconDown.addClass('change-color');
                } else {
                    iconDown.addClass('change-color');
                }
            }
            $.ajax({
                url: url,
                method: "post",
                beforeSend: function (request) {
                    request.setRequestHeader('X-CSRF-TOKEN',csrf)
                },
                data: {react: react}
            }).done(response => {
                if (!response) return;
            }).fail((jqXHR, ajaxOptions, thrownError) => {
                console.log('server error');
            });
        }
        function loadReplies(url,post_id,comment_id,replies_count) {
            let icon = $(`#comment-${post_id}-${comment_id}`+ ' a.onhover> i');
            let replySection = $('#reply-'+post_id+'-to-'+comment_id + '> ul');
            let replyBlock = $(`#reply-${post_id}-to-${comment_id}`);
            let spanText = $(`#comment-${post_id}-${comment_id}`+ ' a.onhover> span');

            if (icon.hasClass('icofont-caret-down')) {
                if (replySection.children().length > 0) {
                    spanText.text(`Ẩn Phản ${replies_count} hồi`);
                    icon.removeClass('icofont-caret-down').addClass('icofont-caret-up');
                    replyBlock.show();
                    return;
                }
                axios.get(url)
                    .then(response => {
                        if(!response) return;
                        spanText.text(`Ẩn Phản ${replies_count} hồi`);
                        icon.removeClass('icofont-caret-down').addClass('icofont-caret-up');
                        replySection.append(response.data.view);
                    }).catch(err => {
                    //TODO swal;
                    console.log(err);
                });
            }
            if (icon.hasClass('icofont-caret-up')) {
                spanText.text(`Xem ${replies_count} phản hồi`);
                icon.removeClass('icofont-caret-up').addClass('icofont-caret-down');
                replyBlock.hide();
            }
        }
        function sendComment(url) {
            event.preventDefault();
            if (user === '') return redirectTo('{{route('login')}}');
            let commentSection = $('.comments-area > ul');
            let userName = '{{auth()->user()->name ?? ''}}';
            let userAvatar = '{{auth()->user()->avatar ?? ''}}';
            let input = $('#commentInput');
            let content = input.val();
            let unqid = randomString(20);
            let html = `
                <li class="d-flex ${unqid}">
                    <div class="commenter-avatar">
                        <img src="${userAvatar}" alt="${userName}">
                    </div>
                    <div class="commenter-wraper">
                        <div class="commenter-info d-flex">
                            <p>${userName}</p>
                        </div>
                        <div class="comment-content">
                            <p style="word-break: break-word">
                                ${content}
                            </p>
                        </div>
                        <div class="replies-area">

                        </div>
                    </div>
                </li>
                `;
            input.val('');
            commentSection.prepend(html);
            let form = $('#commentForm');
            form.submit(false);
            $.ajax({
                url:url,
                method: "post",
                data: {content: content},
                beforeSend: function (request) {
                    request.setRequestHeader('X-CSRF-TOKEN',csrf)
                }
            })
                .done(response => {
                    if (!response) return;
                        let postId = response.data.post_uuid;
                        let commentId = response.data.comment_id;
                        let time = response.data.time;
                        let totalComments = response.data.total_comments;
                        let parrent = $(`.${unqid}`);
                        let info = parrent.find('.commenter-info');
                        let repliesArea = parrent.find('.replies-area');
                        commentsCount.text(`${totalComments}`);
                        info.append(`<span>${time}<span>`);
                        repliesArea.append(`
                            <img src="{{ asset('/assets/images/buttons/arrow-bend-up-right.svg') }}" alt="reply">
                            <span>Trả lời</span>
                            <input class="open-reply-form" type="checkbox">
                            <ul class="replies-list" id="replies-${postId}-list-${commentId}">

                            </ul>
                            <form
                                class="reply-form d-none"
                                onsubmit="sendReply('{{route('post.reply',$post->post_uuid)}}',
                                            '${postId}',
                                            '${commentId}')"
                            >
                                <label>
                                    <img src="${userAvatar}" alt="${userName}">
                                </label>
                                <div class="comment-input">
                                    <input id="replies-${postId}-to-${commentId}" placeholder="Bán gạch cho chủ thớt">
                                    <button class="submit-button" type="submit">
                                        <img src="{!! asset('/assets/images/buttons/paper-plane.svg') !!}" alt="submit">
                                    </button>
                                </div>
                            </form>
                        `);
                        form.submit(true);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });}
        function sendReply(url,post_id,comment_id) {
            event.preventDefault();
            if (user === '') return redirectTo('{{route('login')}}');
            let userName = '{{auth()->user()->name ?? ''}}';
            let userAvatar = '{{auth()->user()->avatar ?? ''}}';
            let replySection = $(`#replies-${post_id}-list-${comment_id}`);
            let input = $(`#replies-${post_id}-to-${comment_id}`);
            let content = input.val();
            let unqid = randomString(20);
            if (replySection.children('li').length === 0) {
                axios.get(`/posts/${post_id}/comments/${comment_id}/show-replies`)
                    .then(response => {
                        replySection.append(response.data.view);
                    })
            }
            let html = `
                <li class="d-flex ${unqid}">
                    <div class="replier-avatar">
                        <img src="${userAvatar}">
                    </div>
                    <div class="replier-details">
                        <div class="commenter-info d-flex">
                            <p>${userName}</p>
                        </div>
                        <div class="comment-content">
                            ${content}
                        </div>
                        <div class="replies-area">
                            <img src="{!! asset('/assets/images/buttons/arrow-bend-up-right.svg') !!}" alt="reply">
                            <span>Trả lời</span>
                        </div>
                    </div>
                </li>
            `;
            input.val('');
            replySection.prepend(html);
            $.ajax({
                url,
                method: 'post',
                beforeSend: function (request) {
                    request.setRequestHeader('X-CSRF-TOKEN',csrf)
                },
                data: {
                    content: content,
                    comment_id: comment_id
                }
            }).done(response => {
                let postId = response.data.post_uuid;
                let commentId = response.data.comment_id;
                let replyId = response.data.reply_id;
                let time = response.data.time;
                console.log(response);
                commentsCount.text(response.data.total_comments);
                $(`.${unqid}`).find('.replier-details .commenter-info').append(`<span>${time}</span>`);

            }).fail(err => {
                console.log(err)
                // Swal.fire()
            });
        }
        $(function () {
            Echo.channel(channel)
                .listen('CommentAndReply', (response) => {
                    console.log(response);
                    let postId = response.data.post_uuid;
                    let commentId = response.data.comment_id;
                    let type = response.data.type;
                    let content = response.data.content;
                    let time = response.data.time;
                    let userName = response.user.name;
                    let userAvatar = response.user.avatar;
                    let commentSection = $('.comments-area > ul');
                    let replySection = $(`#replies-${postId}-list-${commentId}`);
                    let reply_id = response.data.reply_id;
                    commentsCount.text(`${response.data.total_comments}`);
                    if (type === 'comment') {
                        let html = `
                            <li class="d-flex">
                                <div class="commenter-avatar">
                                    <img src="${userAvatar}" alt="${userName}">
                                </div>
                                <div class="commenter-wraper">
                                    <div class="commenter-info d-flex">
                                        <p>${userName}</p>
                                        <span>${time}</span>
                                    </div>
                                    <div class="comment-content">
                                        <p style="word-break: break-word">
                                            ${content}
                                        </p>
                                    </div>
                                    <div class="replies-area">
                                        <img src="{{ asset('/assets/images/buttons/arrow-bend-up-right.svg') }}" alt="reply">
                                        <span>Trả lời</span>
                                        <input class="open-reply-form" type="checkbox">
                                        <ul class="replies-list" id="replies-${postId}-list-${commentId}">

                                        </ul>
                                        <form
                                            class="reply-form d-none"
                                            onsubmit="sendReply('{{route('post.reply',$post->post_uuid)}}',
                                            '${postId}',
                                            '${commentId}')"
                                        >
                                            <label>
                                                <img src="${userAvatar}" alt="${userName}">
                                            </label>
                                            <div class="comment-input">
                                                <input id="replies-${postId}-to-${commentId}" placeholder="Bán gạch cho chủ thớt">
                                                <button class="submit-button" type="submit">
                                                    <img src="{!! asset('/assets/images/buttons/paper-plane.svg') !!}" alt="submit">
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        `;
                        commentSection.prepend(html);
                    }
                    if (type === 'reply') {
                        let html = `
                            <li class="d-flex">
                                <div class="replier-avatar">
                                    <img src="${userAvatar}">
                                </div>
                                <div class="replier-details">
                                    <div class="commenter-info d-flex">
                                        <p>${userName}</p>
                                        <span>${time}</span>
                                    </div>
                                    <div class="comment-content">
                                        ${content}
                                    </div>
                                    <div class="replies-area">
                                        <img src="{!! asset('/assets/images/buttons/arrow-bend-up-right.svg') !!}" alt="reply">
                                        <span>Trả lời</span>
                                    </div>
                                </div>
                            </li>
                        `;
                        if (replySection.children('li').length === 0) {
                            axios.get(`/posts/${post_id}/comments/${comment_id}/show-replies`)
                                .then(response => {
                                    replySection.append(response.data.view);
                                })
                        }
                        replySection.prepend(html);
                    }
                })
                .listen('ReactionsUpdate', (response) => {
                    let uVoteCount = response.data.upvote;
                    let dVoteCount = response.data.downvote;
                    let id = response.data.comment_id;
                    console.log(dVoteCount);
                    console.log(id)
                    $(`.react-to-${id} > a[title="like"] span`).html(`${uVoteCount}`);
                    $(`.react-to-${id} > a[title="dislike"] span`).html(`${dVoteCount}`);
                });
        })
    </script>
@endpushonce
