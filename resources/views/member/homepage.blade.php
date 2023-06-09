@extends('member.layouts.app')
@pushonce('meta')
    <meta name="description" content="Nơi những điều kỳ quái diễn ra" />
    <meta name="keywords" content="Đoán xem,ĐX,Cái quái gì vậy, ?,WTF,Vượt Cổng leo tường,Đoán Đê" />
    <meta property="og:url" content="https://doanxem.com">
    <meta property="og:title" content="Ứng dụng giải trí siêu cấp">
    <meta property="og:site_name" content="Đoán Xem">
    <meta property="og:description" content="Thả mình vào thế giới bao quanh, đắm chìm vào không gian của những video và meme hài chất như nước cất">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{!! asset('/assets/images/land-image.png') !!}">
    <meta property="og:locale" content="vi">
    <title>Đoán xem</title>
@endpushonce
@pushonce('css')
    <style>
        .left-25 {
            left: 25%;
        }
        .mt-40 {
            margin-top: 40px;
        }
        .post-item {
            margin-bottom: 32px;
            padding: 16px 24px;
            background-color: white;
            border-radius: 8px;
        }
        .mh-70 {
            max-height: 70vh;
        }
        .author {
            width: 40px;
            height: 40px;
            margin-right: 1rem;
            border-radius: 4px;
        }
        .author-name {
            font-size: 14px;
            font-weight: 700;
            line-height: 20px;
            color: #0B2347;
            font-family: Averta-PE-Semibold,sans-serif;
        }
        .post-time {
            font-size: 12px;
            line-height: 18px;
            color: #527898;
            font-family: Averta-PE-Semibold,sans-serif;
        }
        .post-title {
            font-family: Averta-PE-Regular,sans-serif;
            color: #3D4953;
            line-height: 16px;

        }
        .post-media {
            width: calc(100% + 48px);
            transform: translateX(-24px);
            background-color: black;
        }
        .break-line {
            border: 1px solid #ECECEC;
            margin: 8px 0;
        }
        .custom-text {
            font-family: Averta-PE-Regular,sans-serif;
            color: #3D4953;
            line-height: 20px;
            font-weight: 600;
        }
        .square-icon-size {
            width: 20px;
            height: 20px;
            margin-right: 4px;
        }
        .rectangle-icon-size {
            width: 12px;
            height: 20px;
        }
        .tool-box {
            width: 30px;
            height: 30px;
        }
        .check-toolbar {
            width: 30px;
            height: 30px;
            z-index: 5;
            position: absolute;
            opacity: 0;
            top: 0;
            left: 0;
        }
        input.check-toolbar:checked ~ .toolbar {
            margin-top: 12px;
            display: block !important;
            width: 275px;
            height: 184px;
            right: 0;
            box-shadow: 0px 2px 10px  rgba(32, 49, 94, 0.2);
            border-radius: 10px;
        }
        .left-center {
            left: 50%;
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
        div.hover-react:hover input.check-react ~ .reacts {
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
        .check-react ~ span {
            line-height: 20px;
            font-family: Averta-PE-Regular,sans-serif;
        }
        .check-react {
            height: 20px;
            width: 20px;
            z-index: 5;
            position: absolute;
            opacity: 0;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        @media (min-width: 992px) {
            #infinite-content {
                left: 33%;
            }
        }
        @media (max-width: 991px) {
            #infinite-content {
                left: 25%;
            }
        }
        @media (max-width: 575px) {
            #infinite-content {
                left: 0;
            }
        }
    </style>
@endpushonce
@section('content')
    <div class="container-fluid">
        <div class="col-12 col-sm-6 col-lg-4 position-relative mt-40" id="infinite-content">

        </div>
    </div>
@endsection
@pushonce('script')
    <script>
        let page = 1;
        let currentRoute = '{{url()->current()}}'
        let csrf = $("meta[name='csrf-token']").attr('content');
        let sudo = '{{auth()->user()}}';
        let container = $('div.container-fluid');
        let checkbox = $('input.check-react[type="checkbox"]');
        infiniteLoadMore(page);
        container.scroll(function () {
            if ($('.post-item').length < page*15) {
                return;
            }
            if (container.scrollTop() >=  $('#infinite-content').height() - $(window).height() - 1) {
                page++;
                infiniteLoadMore(page);
            }
        });
        function infiniteLoadMore(page) {
            $.ajax({
                url: currentRoute +"?page=" + page,
                datatype: "html",
                type: "get",
            })
                .done(function (response) {
                    if (response.length === 0) {
                        $('.auto-load').html("We don't have more data to display :(");
                        return;
                    }
                    $("#infinite-content").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        };
        function handlePostReactions(url,post_uuid) {
            if (!sudo) return redirectTo('/login');
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
        function redirectTo(url) {
            window.location.href = url;
        }
        $('.scroll-down').on('click', function () {
            $('.post-item')[15*page - 1].scrollIntoView({behavior:"smooth"});
        })
    </script>
@endpushonce
