@extends('admin.layouts.app')
@section('page')
    <div class="container d-flex">
        <div class="card" style="width: 40rem; margin: auto; border-radius: 10px 20px; box-shadow: 5px 10px #f0f0f0;height: 750px;">

            <div>
                <div class=" postContent">
                    {{--                    <div class="">--}}
                    {{--                        <a href="{{$posts->avatar}}" style="color:#76838f;">--}}
                    {{--                        </a>--}}
                    {{--                    </div>--}}
                    <a href="#" style="color: black">
                        {{--            <b>{{ detect_extension_post($post->image) }}</b>--}}
                    </a>
                    <div id="font" class="mt-2" style="text-align: center;">
                        Đăng bởi
                        <a href="/uploader/{{$posts->user->id}}">
                            <b>{{ $posts->user->name }} </b>
                        </a>
                        <a href="#" class="time">
                            {{ $posts->created_at->diffForHumans() }}
                        </a>
                        <p style="text-align: center; margin-top: 10px">{{ $posts->title }}</p>
                    </div>
                </div>
                {{--    check anh--}}
                @if (\App\Models\Post::detectExtensionPost($posts->image) === \App\Helpers\Constant::IMAGE)

                    <a href="#">
                        <img id="myImg" class="post-body-image p-2" src="{{$posts->image}}"
                             width="100%"  style="height: 532px;"/>
                    </a>
                @else
                    <video id="myVid" class="post-body-video" preload="auto"
                           loop="loop" controls width="100%" height="auto">
                        <source src="{{$posts->image }}" type="video/mp4">
                    </video>
                @endif
                <div class="footer-mar btn btn-sm btn-default d-flex"
                     style="">

                    <P> Tổng lượng tương tác của bài viết: {{$posts->total_interactive }}</P>
                    <a href="#">
                        <i data-feather='message-square'
                           style="width: 20px; height: 20px; margin-left: 20px"></i> {{$posts->comments->count()}}
                    </a>
                </div>
                <div class="card-footer text-muted">
                    <div class="post-footer">
                <span class="footer-item">

                    <a href="{{ route('admin.showpost') }}" class="btn btn-primary"
                       style="margin-left: 0px">Quay lại</a>

{{--                    <button type="submit"--}}
                    {{--                            class="footer-mar btn btn-sm btn-danger"--}}
                    {{--                            style="margin-left: 10px;height: 38px; width: 70px">--}}
                    {{--                        <a href="{{route("admin.api.post.delete", $posts->post_uuid)}}"--}}
                    {{--                           style="color: white; height: 50px">Xóa</a>--}}
                    {{--                    </button>--}}
                </span>
                    </div>
                </div>
            </div>

        </div>

        <div class="card" style="width: 35rem; margin: auto; border-radius: 10px 20px; box-shadow: 5px 10px #f0f0f0;margin-left: -130px; margin-top: 0px;padding-bottom: ">

            <div>
{{--                <div class=" postContent" style="height: 740px">--}}
                    <h1 class="p-2 ml-2">Comment</h1>
{{--                </div>--}}
                <ul id="comment-{{ $posts->post_uuid }}" style=" overflow-y: auto; overflow-x: none; height: 300px">

                </ul>

            </div>
        </div>

        <script>
            let url = '{{ route('admin.showcomment',$posts->id) }}'
            let commentPage = 1;
            console.log(url)
            loadComment(commentPage);
            let commentSection = $('#comment-{{ $posts->post_uuid }}');
            commentSection.scroll(function (){
                // console.log(commentSection.scrollTop)
                // console.log($(document).height() - commentSection.height() - 100)
                // console.log(commentSection.scrollTop() >= $(document).height() - commentSection.height() - 1)
                if(commentSection.scrollTop() >= $(document).height() - commentSection.height() - 700)
                {
                    commentPage++;
                    loadComment(commentPage);
                }

            });

            function loadComment(page){
             $.ajax({
                url: url + '?page=' + page,
                 method: 'get',
             }).done(response => {
                 if (!response) return;
                 // console.log(response);
                 commentSection.append(response);

             }).fail((error) => {
                 console.log(error)
             });
            }
        </script>
@endsection

