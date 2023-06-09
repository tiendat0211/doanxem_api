


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

                                        {{--    check video--}}
                                        {{--        <div class="videoPost">--}}
                                        {{--            --}}
                                        {{--        </div>--}}
                                    @else


                                        <video id="myVid" class="post-body-video" preload="auto"
                                               loop="loop" controls width="100%" height="auto" style="padding: 20px">
                                            <source src="{{$post->image }}" type="video/mp4">
                                        </video>

                                    @endif
                                </div>
                            @endforeach
                            <div class="ajax-load text-center" style="display:none">
                                <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
                            </div>

                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>

        @endif
            {!! $posts->links('vendor.pagination.bootstrap-4') !!}



