@extends('member.layouts.app')
@push('title')
    Đoán Xem - {{$user->name}}
@endpush
@push('css')
    <style>
        .like {
            background-image: url('/theme/images/smiles/thumb.png');
            background-size: cover;
            background-position: center;
            height: 20px;
            width: 20px;
        }
        .heart {
            background-image: url('/theme/images/smiles/heart.png');
            background-size: cover;
            background-position: center;
            height: 20px;
            width: 20px;
        }
        .haha {
            background-image: url('/theme/images/smiles/happy.png');
            background-size: cover;
            background-position: center;
            height: 20px;
            width: 20px;
        }
        .wow{
            background-image: url('/theme/images/smiles/suspicious.png');
            background-size: cover;
            background-position: center;
            height: 20px;
            width: 20px;
        }
        .sad {
            background-image: url('/theme/images/smiles/unhappy.png');
            background-size: cover;
            background-position: center;
            height: 20px;
            width: 20px;
        }
        .angry {
            background-image: url('/theme/images/smiles/angry.png');
            background-size: cover;
            background-position: center;
            height: 20px;
            width: 20px;
        }
        .pop-image {
            height: 100vh;
            padding: 0;
        }
        .comments-area > ul::-webkit-scrollbar {
            width:0;
        }
        div a {
            color: #088dcd;
        }
        .comments-area div {
            color: #088dcd;
        }
        .commenter {
            background: inherit;
        }
        ins {
            color: #088dcd;
        }
        .reply-block {
            background: #4a5464;
            width: 80%;
            margin-right: 0;
            margin-left:auto;
        }
        figure {
            margin: 0;
        }
        .image-width {
            width: 45%;
            object-fit: cover;
            align-items: center;
            margin: auto;
        }
        .full-scale {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .full-scale > video {
            width: 100%;
            height: 100%;
        }
        .normie {
            color: black !important;
        }
        .pro {
            color: #0d6cb1 !important;
        }
        .vip-pro {
            color: orange !important;
        }
        .almighty {
            color: red !important;
        }
        @media (min-width: 320px) and (max-width: 768px) {
            .modal-dialog {
                width: auto;
                margin: 4rem 0 0 0;
                max-width: none !important;
            }
            .pop-image {
                height: auto;
                padding: 2rem 0;
            }
        }
        @media (max-width: 634px) {
            #name-member {
                display: none;
            }
            .user-avatar > a {
                width: 100%;
                display: flex;
                justify-content: center;
            }
            .logo > span {
                display: none;
            }
            .logo.res {
                width: 34%;
            }
        }
        @media (min-width:768px) and (max-width: 992px) {
            .modal-dialog {
                margin: 4rem auto 1.75rem auto;
                max-width: fit-content;
            }

            .col-lg-3 {
                display: flex;
                flex-direction: column;
            }
            .pop-image {
                height: auto;
                padding: 2rem 0;
            }
        }
        @media (min-width: 992px) {
            .modal-dialog {
                max-width: none;
                margin: 0;
            }
        }
        svg.feather {
            stroke: #82828e;
        }
    </style>
@endpush
@section('content')
    <section>
        {{--        <div class="gap">--}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 p-0 col-md-6 col-sm-7">
                    <div id="page-contents" class="row merged20">
                        <div class="col-lg-12">
                            <ul class="filtr-tabs">
                                {{--                                    <li><a class="active" href="index.html#" title="">Home</a></li>--}}
                                {{--                                    <li><a href="index.html#" title="">Recent</a></li>--}}
                                {{--                                    <li><a href="index.html#" title="">Favourit</a></li>--}}
                            </ul><!-- tab buttons -->
                            <div id="infinite-content">
                                @foreach($posts as $post)
                                    <div class="main-wraper p-0 mb-3">
                                        <div class="user-post">
                                            <div class="friend-info mt-1">
                                                <div class="infor-member d-flex p-2">
                                                    <figure>
                                                        <img style="border-radius: 50%;width:30px;height: 30px" alt="" src="{{ $user->avatar }}">
                                                    </figure>
                                                    <div class="friend-name">
                                                        <ins>
                                                            <a title="" href="#" class="user-name">{{ $user->name }}</a>
                                                        </ins>
                                                        <span>{{$post->time}}</span>
                                                    </div>
                                                </div>
                                                <div class="post-meta m-0 p-0" id="post-meta-{{ $post->post_uuid }}"
                                                     data-image="{{ $post->image }}"
                                                     data-title="{{ $post->title }}"
                                                     data-author="{{ $user->name }}"
                                                     data-time="{{ $post->time }}"
                                                     data-avatar="{{$user->avatar}}">
                                                    <p class="m-0 p-2" style="color:black; font-weight: 600; font-size: 18px">{{ $post->title }}</p>
                                                    <figure>
                                                        <a data-toggle="modal" data-target="#post-detail-modal"
                                                           onclick="showPostDetail('/posts/{{ $post->post_uuid }}/comments','{{ $post->post_uuid }}')"
                                                           class="full-scale">
                                                            @if(empty($post->file) || empty($post->file->get('file_type')))
                                                                <img src="{{ $post->image }}" alt="">
                                                            @elseif(!empty($post->file))
                                                                @if($post->file->file_type == 'video')
                                                                    <video controls>
                                                                        <source src="{{$post->image}}" type="{{ \Illuminate\Support\Facades\Storage::mimeType($post->file->url) }}">
                                                                    </video>
                                                                @elseif($post->file->file_type == 'image')
                                                                    <img src ="{{ $post->file->url }}" >
                                                                @endif
                                                            @else
                                                                <img src="{{ $post->file->url}}" alt="">
                                                            @endif
                                                        </a>
                                                    </figure>
                                                    <div class="stat-tools m-0 p-3">
                                                        <div class="box">
                                                            <div class="Like">
                                                                <a class="Like__link" id="react-to-{{$post->post_uuid}}">
                                                                    @if ($post->user_action != 'none')
                                                                        <div class="{{$post->user_action}}"></div>
                                                                    @else
                                                                        <i class="icofont-like"></i>
                                                                    @endif
                                                                </a>
                                                                <div class="Emojis">
                                                                    <div class="Emoji Emoji--like">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/like","{{$post->post_uuid}}","like")'>
                                        <div class="icon icon--like "></div>
                                    </span>
                                                                    </div>
                                                                    <div class="Emoji Emoji--love">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/heart","{{$post->post_uuid}}","like")'>
                                        <div class="icon icon--heart"></div>
                                    </span>
                                                                    </div>
                                                                    <div class="Emoji Emoji--haha">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/haha","{{$post->post_uuid}}","haha")'>
                                        <div class="icon icon--haha"></div>
                                    </span>
                                                                    </div>
                                                                    <div class="Emoji Emoji--wow">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/wow","{{$post->post_uuid}}","wow")'>
                                        <div class="icon icon--wow"></div>
                                    </span>
                                                                    </div>
                                                                    <div class="Emoji Emoji--sad">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/sad","{{$post->post_uuid}}","sad")'>
                                        <div class="icon icon--sad"></div>
                                    </span>
                                                                    </div>
                                                                    <div class="Emoji Emoji--angry">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/angry","{{$post->post_uuid}}","angry")'>
                                        <div class="icon icon--angry"></div>
                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="box">
                                                            <div class="Emojis">
                                                                <div class="Emoji Emoji--like">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/like","{{$post->post_uuid}}","like")'>
                                        <div class="icon icon--like "></div>
                                    </span>
                                                                </div>
                                                                <div class="Emoji Emoji--love">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/heart","{{$post->post_uuid}}","heart")'>
                                        <div class="icon icon--heart"></div>
                                    </span>
                                                                </div>
                                                                <div class="Emoji Emoji--haha">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/haha","{{$post->post_uuid}}","haha")'>
                                        <div class="icon icon--haha"></div>
                                    </span>
                                                                </div>
                                                                <div class="Emoji Emoji--wow">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/wow","{{$post->post_uuid}}","wow")'>
                                        <div class="icon icon--wow"></div>
                                    </span>
                                                                </div>
                                                                <div class="Emoji Emoji--sad">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/sad","{{$post->post_uuid}}","sad")'>
                                        <div class="icon icon--sad"></div>
                                    </span>
                                                                </div>
                                                                <div class="Emoji Emoji--angry">
                                    <span onclick='handleReactions("/member/posts/{{ $post->post_uuid }}/angry","{{$post->post_uuid}}","angry")'>
                                        <div class="icon icon--angry"></div>
                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a style="cursor: pointer" class="comment-to"  data-toggle="modal" data-target="#post-detail-modal"
                                                           onclick="showPostDetail('/posts/{{ $post->post_uuid }}/comments','{{ $post->post_uuid }}')">
                                                            {{ $post->comments->count() }}
                                                            <i class="icofont-comment"></i>
                                                        </a>
                                                        {{--                    TODO: ?>><--}}
                                                        {{--                    <a onclick="useLessButton()" class="share-to cursor-pointer"><span class="count"></span><i--}}
                                                        {{--                            class="icofont-share-alt"></i> Share</a>--}}
                                                        {{--                    <div>--}}
                                                        {{--                        <a onclick="Share.facebook('URL','TITLE','IMG_PATH','DESC')" class="a2a_button_facebook">Facebook</a>--}}
                                                        {{--                        <a onclick="Share.twitter('URL','TITLE')" class="a2a_button_twitter">Twitter</a>--}}
                                                        {{--                    </div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! $posts->links('vendor.pagination.default') !!}
@endsection
@push('scripts')
    <script>
        function handleReactions(url,post_id,react) {

            $('#react-to-' + post_id).html(`
                <div class="${react}"></div>
            `);
            $.ajax({
                url:  url,
                type: "get",
            })
                .done(response=>{
                    if (!response) return
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured')
                });
        }
    </script>
@endpush



