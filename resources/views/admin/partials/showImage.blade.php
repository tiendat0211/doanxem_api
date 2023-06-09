
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="card post userPost">
                    <div class="card-header postContent">
                        <div class="card-title d-flex justify-content-between">
                            <a href="{{$post->user->avatar}}" style="color:#76838f;">
                                {{--                <b>{{ $post->title }}</b>--}}
                            </a>
                        </div>
                        <a href="#" style="color: black">
                            {{--            <b>{{ detect_extension_post($post->image) }}</b>--}}
                        </a>
                        <div id="font" style="text-align: center">
                            Đăng bởi
                            <a  href="/uploader/{{$post->user->id}}">
                                <b>{{ $post->user->name }} </b>
                            </a>
                            <a href="#" class="time">
                                {{ $post->created_at->diffForHumans() }}
                            </a>
                        </div>
                        {{--        <input type="checkbox" name="post_id" class="checkbox" value="{{$post->post_uuid}}">--}}
                    </div>
                    {{--    check anh--}}
                    @if (\App\Models\Post::detectExtensionPost($post->image) === \App\Helpers\Constant::IMAGE)

                        <a href="{{ route('admin.showdetailPost',$post->id) }}">
                            <img id="myImg" class="post-body-image" src="{{$post->image}}"
                                 width="100%" height="auto" style="height: 300px"/>
                        </a>
                    @else
                        <video id="myVid" class="post-body-video" preload="auto"
                               loop="loop" controls width="100%" height="auto">
                            <source src="{{$post->image }}" type="video/mp4">
                        </video>
                    @endif
                    <div class="card-footer text-muted">
                        <div class="post-footer">
                <span class="footer-item">
                    <div class="footer-mar btn btn-sm btn-default">{{ $post->upvote }}
                        <i class="fa fa-arrow-up"></i>
                    </div>
                    <div class="footer-mar btn btn-sm btn-default">{{ $post->downvote }}
                        <i class="fa fa-arrow-up"></i>
                    </div>
                    <div class="footer-mar btn btn-sm btn-default"
                         style="display: none">
                        <a href="/images/{{ $post->id }}">
                            {{$post->comments->count()}}
                            <i class="fa fa-comment"></i>
                        </a>
                    </div>

                    <button type="submit"
                            class="footer-mar btn btn-sm btn-danger" style="margin-left: -100px">
                        <a href="{{route("admin.api.post.delete", $post->post_uuid)}}" style="color: white;" >Xóa</a>
                    </button>
                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



