@extends('admin.layouts.app')

@section('css')
    {{--   --}}
@endsection
@section('page')


{{--    <div class="" style="display: flex; background: #ffffff; height: 50px; border-radius: 20px;">--}}
{{--        <h3 style="margin:10px">Bài viết chưa duyệt</h3>--}}

{{--        <form method="post" action="{{ route('admin.post_show_all') }}" class="form-item"--}}
{{--              style="display: inline-block; margin-left: 70%; margin-top: 10px">--}}
{{--            @csrf--}}
{{--            --}}{{--        <input type="hidden" value="{{$post->post_uuid}}" name="post_id">--}}
{{--            <button class="footer-mar btn btn-sm btn-success"><i--}}
{{--                    class="fa fa-check"></i>Phê duyệt tất cả</button>--}}
{{--        </form>--}}
{{--    </div>--}}

    <div class="row" style="margin: 30px 0">
        @if ($posts->isEmpty())
            <div class="img" style="margin-top: 140px; width: 750px; margin: auto">
                <img src="/assets/images/70233914_1154118831445605_7028280506034683904_n.jpg">
                {{--                            <h1>đếu có bài nào cả!</h1>--}}
            </div>
        @else
            @foreach($posts as $index => $post)

                <div class="col-md-3">
                    <div class="card" style="height: 550px;">
                        <div class="card-body">
                            <div class="card post userPost" >
                                <div class="card-header postContent" style="padding: 10px 10px 5px 10px;">
                                    <div class="card-title d-flex justify-content-between width-95-per">
                                        <a class="width-95-per" href="{{--$post->avatar--}}" style="color:#76838f;text-overflow: ellipsis;overflow: hidden;height: 25px">
                                            <b>{{ $post->title }}</b>
                                        </a>
                                        {{--                                        <input type="checkbox" name="post_id" class="checkbox" id="{{$index}}" value="{{$post->post_uuid}}">--}}
                                    </div>
                                    <div id="font">
                                        Đăng bởi
                                        <a href="{{@$post->user->avatar}}">
                                            <b>{{ $post->user->name }} </b>
                                        </a>
                                        <a href="#" class="time">
                                            {{ $post->created_at->diffForHumans() }}
                                        </a>
                                    </div>
                                </div>
                                {{--    check anh--}}
                                    <?php  $imgTail = explode('.', $post->image); ?>
                                @if ($imgTail[count($imgTail) - 1] == "jpg" ||$imgTail[count($imgTail) - 1] == "png" || $imgTail[count($imgTail) - 1] == "jpeg" || $imgTail[count($imgTail) - 1] == "gif")

                                    <a href="{{ $post->post_uuid}}">
                                        <img id="myImg" class="post-body-image" src="{{asset($post->image)}}"
                                             width="100%" height="auto" style="padding: 20px; height: 300px" />
                                    </a>
                                    <div class="card-footer text-muted">
                                        <div class="post-footer">
                                            <span class="footer-item">
                                            <form method="post" action="{{ route('admin.post_show') }}" class="form-item"
                                                  style="display: inline-block">
                                                @csrf
                                                <input type="hidden" value="{{$post->post_uuid}}" name="post_id">
                                                <button class="footer-mar btn btn-sm btn-success"
                                                        type="button" onclick="validatePost('{{$post->post_uuid}}','{{route('admin.post_show')}}')"><i
                                                        class="fa fa-check"></i>Phê duyệt</button>
                                            </form>
                                            <form method="post" action="{{ route('admin.post_hide') }}" class="form-item"
                                                  style="display: inline-block">
                                                @csrf
                                                <input type="hidden" value="{{$post->post_uuid}}" name="post_id">
                                                <button class="footer-mar btn btn-sm btn-danger"
                                                        type="button" onclick="validatePost('{{$post->post_uuid}}','{{route('admin.post_hide')}}')"><i
                                                        class="fa fa-close"></i>Ẩn</button>
                                            </form>
                                            </span>
                                        </div>
                                    </div>
                                    {{--    check video--}}
                                @else

                                    <video id="myVid" class="post-body-video" preload="auto"
                                           loop="loop" controls width="100%" height="auto" style="padding: 20px; height: 300px" >
                                        <source src="{{$post->image }}" type="video/mp4">
                                    </video>
                                    <div class="card-footer text-muted">
                                        <div class="post-footer">
                                            <span class="footer-item">
                                            <form method="post" action="{{ route('admin.post_show') }}" class="form-item"
                                                  style="display: inline-block">
                                                @csrf
                                                <input type="hidden" value="{{$post->post_uuid}}" name="post_id">
                                                <button class="footer-mar btn btn-sm btn-success"
                                                        type="button" onclick="validatePost('{{$post->post_uuid}}','{{route('admin.post_show')}}')"><i
                                                        class="fa fa-check"></i>Phê duyệt</button>
                                            </form>
                                            <form method="post" action="{{ route('admin.post_hide') }}" class="form-item"
                                                  style="display: inline-block">
                                                @csrf
                                                <input type="hidden" value="{{$post->post_uuid}}" name="post_id">
                                                <button class="footer-mar btn btn-sm btn-danger"
                                                        type="button" onclick="validatePost('{{$post->post_uuid}}','{{route('admin.post_hide')}}')"><i
                                                        class="fa fa-close"></i>Ẩn</button>
                                            </form>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach



            {{--                </div>--}}

            {{--            </div>--}}
            {{--        </div>--}}
    </div>
    @endif
    {!! $posts->links('vendor.pagination.bootstrap-4') !!}
@endsection

@section('js')
    <!-- Page -->

    <script>
        function validatePost(postId,url) {
            $.ajax({
                url: url,
                method: 'post',
                beforeSend: function (request) {
                    request.setRequestHeader('X-CSRF-TOKEN','{{csrf_token()}}')
                },
                data: {
                    post_id: postId
                }
            })
                .done(response => {
                    console.log(response);
                    if (!response) return;
                    if (response.status === 200) {
                        alert(response.message);
                        $('#card-' + postId).remove();
                    }
                })
                .fail(err){
                    alert(err);
                }
        }
    </script>
@endsection
