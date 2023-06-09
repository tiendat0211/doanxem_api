@extends('admin.layouts.app')
@section('page')
    <div class="container">
        <div class="row" style="margin: 50px 0">
            <div class="col-md-3 col-lg-2"></div>
            <div id="leftColumn" class="col-md-5 offset-2">
                <div class="" id="postImage" style="">
                    <div class="post-content" id="post-data">
                        @if ($posts->isEmpty())
                            <div class="img" style="margin-top: 140px">
                                <img src="/assets/images/70233914_1154118831445605_7028280506034683904_n.jpg">
                            </div>
                        @else
                            @foreach($posts->reverse() as $post)
                                <div class="card post userPost" style="margin-bottom: 50px;">
                                    <div class="card-header postContent" style="padding: 10px 10px 5px 10px;">
                                        <a href="#">
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
                                            <img id="myImg" class="post-body-image" src="{{asset($post->image)}}"
                                                 width="100%" height="auto"/>
                                        </a>
                                        <div class="card-footer text-muted">
                                            <div class="post-footer">
                                                <span class="footer-item">
                                                        <button class="footer-mar btn btn-sm btn-default">{{ $post->upvote }}<i
                                                                class="fa fa-arrow-up"></i></button>
                                                        <button class="footer-mar btn btn-sm btn-default">{{ $post->downvote }}<i
                                                                class="fa fa-arrow-up"></i></button>
                                                        <button class="footer-mar btn btn-sm btn-default"><a
                                                                href="/images/{{ $post->id }}">
                                                                {{$post->comments->count()}} <i
                                                                    class="fa fa-comment"></i>
                                                            </a>
                                                        </button>
                                                    </span>
                                            </div>
                                        </div>
                                        {{--    check video--}}
                                    @else
                                </div>
                                {{--    check video--}}
                                <video id="myVid" class="post-body-video" preload="auto"
                                       loop="loop" controls width="100%" height="auto">
                                    <source src="{{$post->image }}" type="video/mp4">
                                </video>
                                <div class="card-footer text-muted">
                                    <div class="post-footer">
                                        <div class="footer-item">
                                            <div action="/posts/upvote" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{$post->public_id}}"
                                                       name="post_id">
                                                <span class="footer-item">
                                    <button>{{ $post->upvote }}<i class="fa fa-arrow-up"></i></button>
                                                        </span>
                                                <span class="footer-item"></span>
                                            </div>
                                        </div>
                                        <div class="footer-item">
                                            <div action="/posts/downvote" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{$post->public_id}}"
                                                       name="post_id">
                                                <span class="footer-item">
                                                            <button>{{ $post->downvote }}<i
                                                                    class="fa fa-arrow-down"></i></button>
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
                                <video id="myVid" class="post-body-video" preload="auto"
                                       loop="loop" controls width="100%" height="auto">
                                    <source src="{{$post->image }}" type="video/mp4">
                                </video>
                                <div class="card-footer text-muted">
                                    <div class="post-footer">
                                        <div class="footer-item">
                                            <div action="/posts/upvote" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{$post->public_id}}"
                                                       name="post_id">
                                                <span class="footer-item">
                                                             <button>{{ $post->upvote }}<i
                                                                     class="fa fa-arrow-up"></i></button>
                                                        </span>
                                            </div>
                                        </div>
                                        <div class="footer-item">
                                            <div action="/posts/downvote" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{$post->public_id}}"
                                                       name="post_id">
                                                <span class="footer-item">
                                                            <button>{{ $post->downvote }}<i
                                                                    class="fa fa-arrow-down"></i></button>
                                                        </span>
                                            </div>
                                        </div>
                                        <div class="footer-item">
                                            <button class="btn btn-sm btn-default" onclick="checkAuth()">
                                                {{$post->comments->count()}} <i class="fa fa-comment"></i>
                                            </button>
                                        </div>
                                        <div class="fb-share-button"
                                             data-href="https://fun.sphoton.com/posts/{{$post->public_id}}"
                                             data-layout="button"
                                             data-size="small"><a target="_blank"
                                                                  href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"
                                                                  class="fb-xfbml-parse-ignore">Chia sẻ</a>
                                        </div>
                                    </div>
                                </div>
                                @endif

                    </div>

                    @endforeach
                </div>
                <div class="ajax-load text-center" style="display:none">
                    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
                </div>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>

    @endif
    {!! $posts->links('vendor.pagination.bootstrap-4') !!}
@endsection
