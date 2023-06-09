

<h1>Tất cả bài viết</h1>
<div class="row" id="post-data">


    @foreach($posts as $post)
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card post userPost">
                        <div class="card-header postContent">
                            <div class="card-title d-flex justify-content-between">
                                <a href="{{$post->avatar}}" style="color:#76838f;">
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
                                    {{ $post->time }}
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
    @endforeach

</div>
{{$posts->links('vendor.pagination.bootstrap-4')}}
<div class="ajax-load text-center" style="display:none">
    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
</div>


<script>
    $('.post-action').on('click', function () {
        const type = $(this).attr('data-type');
        const checkedPost = $('input[type=checkbox]:checked');
        let checked = [];
        checkedPost.each(function (index, post) {
            checked.push(post.value);
        })

        if (!checked.length) {
            alert('Bạn chưa chọn bài nào, vui lòng chọn lại, pờ li  🐱🐱🐱');
            return -1;
        }

        axios.post('{{route("admin.action_post")}}', {
            type, checked
        })
            .then(resp => {
                const {code, message} = resp.data;
                if (code === 200) {
                    alert(message + '🐱🐱🐱');
                    location.reload();
                }
            })
    })
    $(document).ready(function() {
        $('.fixed-navbar').hide();
        $(document).on('scroll', function () {
            $('.fixed-navbar').show();
        })
    })
    let page = 2;

    function deletePost(uuid) {
        fetch('{{route("admin.api.post.delete", '')}}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({post_uuid : uuid})
        }).then(resp => resp.json()).then(data => {
            alert(data.data.message);
            window.location.reload();
        })
    }
    function detectmob() {
        if (navigator.userAgent.match(/Android/i)
            || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/iPhone/i)
            || navigator.userAgent.match(/iPad/i)
            || navigator.userAgent.match(/iPod/i)
            || navigator.userAgent.match(/BlackBerry/i)
            || navigator.userAgent.match(/Windows Phone/i)
        ) {
            return true;
        } else {
            return false;
        }
    }

    if (!detectmob()) {
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height())  {
                loadMoreData();
            }
        });
    } else {
        $(document).scroll(function () {
            if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
                loadMoreData();
            }
        });
    }

    function loadMoreData() {
        let url = '/admin/loadmore?page=' + page;
        console.log(url);
        fetch(url, {
            method: 'GET', // *GET, POST, PUT, DELETE, etc.
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json()).then(responJson => {
            $('.ajax-load').hide();
            $("#post-data").append(responJson.html);
            page = page + 1;
        });
    }
</script>



