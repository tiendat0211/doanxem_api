@extends('layouts.app')
@section('css')
    <style>
        .div-comment {
            flex-grow: 1;
        }

        .div-btn {
            display: flex;
            justify-content: center;
            align-self: center;
        }

        #font {
            font-size: 11px;
        }

        .time {
            color: #606770;
        }

        .footer-mar {
            margin-right: 10px;
        }
    </style>
@endsection

@section ('page')
    <div class="row" style="margin-top: 10px">
        <div class="col-md-3 col-sm-12 offset-sm-0" style="margin: 10px auto; max-width: unset !important;">
            <div class="post-content">
                <div class="card post userPost" style="margin-bottom: 50px;">
                    <div class="card-header postContent" style="padding: 10px 10px 5px 10px;">
                        <a href="/posts/images/{{ $post->public_id }}">
                            <b>{{ $post->title }}</b>
                        </a>
                        <div id="font">
                            Đăng bởi
                            <a href="/uploader/{{$post->user->id}}">
                                <b>{{ $post->user->name }} </b>
                            </a>
                            <a href="#" class="time">
                                {{ $post->created_at->diffForHumans() }}
                            </a>
                        </div>
                    </div>
                    {{--    check anh--}}
                    <?php  $imgTail = explode('.', $post->image); ?>
                    @if ($imgTail[1] == "jpg" ||$imgTail[1] == "png" || $imgTail[1] == "jpeg" || $imgTail[1] == "gif")
                        <a href="/posts/images/{{ $post->public_id}}">
                            <img id="myImg" class="post-body-image" src="{{$post->image }}" width="100%" height="auto"/>
                        </a>
                        <div class="card-footer text-muted">
                            <div class="post-footer">
                                <span class="footer-item">
                                    <button class="footer-mar btn btn-sm btn-default">{{ $post->upvote }}<i
                                            class="fa fa-arrow-up"></i></button>
                                    <button class="footer-mar btn btn-sm btn-default">{{ $post->downvote }}<i
                                            class="fa fa-arrow-up"></i></button>
                                    <button class="footer-mar btn btn-sm btn-default">
                                        <a href="/images/{{ $post->id }}">
                                            {{$post->comments->count()}} <i class="fa fa-comment"></i>
                                        </a>
                                    </button>
                                </span>
                            </div>
                        </div>
                </div>
                @else
                    @if (Auth::check())
                        <video id="myVid" class="post-body-video" preload="auto"
                               loop="loop" controls width="100%" height="auto">
                            <source src="{{$post->image }}" type="video/mp4">
                        </video>
                        <div class="card-footer text-muted">
                            <div class="post-footer">
                                <div class="footer-item">
                                    <div action="/posts/upvote" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$post->public_id}}" name="post_id">
                                        <span class="footer-item">
                                    <button id="upvote-{{$post->public_id}}"
                                            class="btn btn-sm {{ $post->currentReaction() == 'upvote' ? 'btn-success' : 'btn-default' }} btn-sm"
                                            onclick="upvote('{{$post->public_id}}', '{{ csrf_token() }}')">{{ $post->upvote }}
                    <i class="fa fa-arrow-up"></i></button>
                            </span>
                                        <span class="footer-item"></span>
                                    </div>
                                </div>
                                <div class="footer-item">
                                    <div action="/posts/downvote" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$post->public_id}}" name="post_id">
                                        <span class="footer-item">
                                    <button id="downvote-{{$post->public_id}}"
                                            class="btn {{ $post->currentReaction() == 'downvote' ? 'btn-danger' : 'btn-default' }} btn-sm"
                                            onclick="downvote('{{$post->public_id}}', '{{ csrf_token() }}')">{{ $post->downvote }}
                    <i class="fa fa-arrow-down"></i></button>
                            </span>
                                        <span class="footer-item"></span>
                                    </div>
                                </div>
                                <div class="footer-item">
                                    <button class="btn btn-sm btn-default"><a
                                            href="/posts/videos/{{ $post->public_id }}">
                                            {{$post->comments->count()}} <i class="fa fa-comment"></i>
                                        </a>
                                    </button>
                                </div>

                            </div>
                        </div>
                    @else
                        <video id="myVid" class="post-body-video" preload="auto"
                               loop="loop" controls width="100%" height="auto">
                            <source src="{{$post->image }}" type="video/mp4">
                        </video>
                        <div class="card-footer text-muted">
                            <div class="post-footer">
                                <div class="footer-item">
                                    <div action="/posts/upvote" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$post->public_id}}" name="post_id">
                                        <span class="footer-item">
                                 <button id="upvote-{{$post->public_id}}"
                                         class="btn btn-sm {{ $post->currentReaction() == 'upvote' ? 'btn-success' : 'btn-default' }}"
                                         onclick="checkAuth()">{{ $post->upvote }}
                <i class="fa fa-arrow-up"></i></button>
                            </span>
                                    </div>
                                </div>
                                <div class="footer-item">
                                    <div action="/posts/downvote" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$post->public_id}}" name="post_id">
                                        <span class="footer-item">
                                <button id="downvote-{{$post->public_id}}"
                                        class="btn btn-sm {{ $post->currentReaction() == 'downvote' ? 'btn-danger' : 'btn-default' }}"
                                        onclick="checkAuth()">{{ $post->downvote }}
                    <i class="fa fa-arrow-down"></i></button>
                            </span>
                                    </div>
                                </div>
                                <div class="footer-item">
                                    <button class="btn btn-sm btn-default" onclick="checkAuth()">
                                        {{$post->comments->count()}} <i class="fa fa-comment"></i>
                                    </button>
                                </div>

                            </div>
                            @endif
                            @endif


                        </div>
                        <div class="comment-section">
                            <div id="comment-top"></div>
                            @foreach($comments->reverse() as $comment)
                                <div class="comment-item">
                                    <div class="comment-block">
                                        <span class="comment-block-text">
                                     <a id="cmt-user" href="#">{{ $comment->user->name }}</a>
                                     {{ $comment->content }}
                                         </span>
                                    </div>
                                </div>
                                    <div class="comment-footer">
                                        <div class="footer-item">
                                            <div class="footer-block react-block upvote-block">
                                                <a id="upvote">
                                                    <i class="fa fa-arrow-up">{{$comment->upvote}}</i></a>
                                            </div>
                                        </div>
                                        <div class="footer-item">
                                            <div class="footer-block react-block">
                                                <a id="downvote"><i class="fa fa-arrow-down">{{$comment->downvote}}</i></a>
                                            </div>
                                        </div>
{{--                                        <div class="footer-item">--}}
{{--                                            <div class="footer-block react-block">--}}
{{--                                                <a--}}
{{--                                                    class=""--}}
{{--                                                    onclick="showReply('{{ $comment->id }}')">{{ $comment->replies->count() }}--}}
{{--                                                    <i--}}
{{--                                                        class="fa fa-comment-o"></i></a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="time-block footer-block comment-time">
                                            <a href="#"
                                               class="time-color">{{ $comment->created_at->diffForHumans() }}</a>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="reply-block" id="reply-of-{{ $comment->id }}" style="display: none">--}}
{{--                                    <div class="reply-section">--}}
{{--                                        <div id="reply-top"></div>--}}
{{--                                        @foreach($comment->replies->reverse() as $reply)--}}
{{--                                            @include('partials.reply')--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    <div class="reply-block" style="margin-top: -30px;">--}}
{{--                                        <div class="form" method="post" action="/replies">--}}
{{--                                            {{ csrf_field()}}--}}
{{--                                            <input type="hidden" value="{{$comment->id}}" name="comment_id">--}}
{{--                                            <span class="reply-block">--}}
{{--                 <div class="input-group col-sm-6">--}}
{{--                --}}{{--                                    <a href="#" value="{{ $user->name }}"></a>--}}
{{--                <input type="text" class="form-control reply-control" id="reply-content"--}}
{{--                       placeholder="Nhập phản hồi"--}}
{{--                       aria-label="leave some comment"--}}
{{--                       aria-describedby="button-addon2" name="reply_content">--}}
{{--            </div>--}}
{{--            <input type="button" class="btn btn-sm btn-primary" id="replyButton"--}}
{{--                   onclick="addReply('{{$comment->id}}', '{{ csrf_token() }}')" style="display:none">--}}
{{--            </input>--}}
{{--            </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            @endforeach
                        </div>
            </div>
        </div>
    @endsection

    @section('js')
        <!-- Page -->
            <script src="/assets/js/Site.js"></script>
            <script src="/assets/global/js/Plugin/asscrollable.js"></script>
            <script src="/assets/global/js/Plugin/slidepanel.js"></script>
            <script src="/assets/global/js/Plugin/switchery.js"></script>
            <script src="/assets/global/js/Plugin/datatables.js"></script>
            <script src="/assets/examples/js/tables/datatable.js"></script>
@endsection
