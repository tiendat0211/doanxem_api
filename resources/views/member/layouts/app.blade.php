<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="application-name" content="Đoán Xem">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="16x16">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="24x24">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="32x32">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="64x64">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="96x96">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="{!! asset('/assets/css/style.css') !!}">
    @include('layouts.custom-font')
    <style>
        body {
            background-image: url("{!! asset('/assets/images/home-page.jpg') !!}");
            background-size: cover;
            background-repeat: repeat-y;
            font-size : 16px;
            font-weight: 400;
            line-height: 22px;
            font-family: Averta-PE-Bold, sans-serif;
            height: 100vh;
        }
        body > .container-fluid {
            overflow-y: auto;
            height: calc(100vh - 82px);
        }
        .nav-bar {
            height: 56px;
            background-color: #FFFFFF;
        }
        .position-left {
            left: 7%;
        }
        .position-right {
            right: 7%;
        }
        .logo {
            width: 40px;
            height: 40px;
        }
        .w-18 {
            width: 18%;
        }
        .ml-1 {
            margin-left: 1rem;
        }
        .disabled {
            filter: invert(49%) sepia(17%) saturate(1090%) hue-rotate(166deg) brightness(87%) contrast(82%);
        }
        .active {
            filter: invert(69%) sepia(96%) saturate(7492%) hue-rotate(204deg) brightness(107%) contrast(102%);
        }
        a {
            text-decoration: none;
        }
        .avatar {
            height: 34px;
            width: 34px;
            border-radius: 4px;
        }
        .add-new {
            height: 34px;
            background-color: #0177FD;
            border-radius: 4px;
            width: 100px;
            font-size: 12px;
            line-height: 18px;
            color: white;
        }
        .pen-plus {
            height: 13px;
            width: 13px;
        }
        .ico-disabled {
            filter: invert(78%) sepia(0%) saturate(1%) hue-rotate(160deg) brightness(89%) contrast(94%);
        }
        .ico-activated {
            filter: invert(31%) sepia(72%) saturate(4355%) hue-rotate(204deg) brightness(105%) contrast(99%);
        }
        .tab-active {
            border-bottom: 2px solid #0177FD;
            height: 100%;
        }
        .mr-3 {
            margin-right: 1rem;
        }
        .avatar-link {
            position: relative;
        }
        .dropDown-link {
            position: absolute !important;
            top: 110%;
            right: 0;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s linear;
            width: 150px;
            background: white;
            border-radius: 10px;
        }
        .link-item {
            border-radius: 10px;
            height: 40px;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .link-item > span {
            color: #3D4953;
            line-height: 24px;
            font-weight: 500;
            font-size: 14px;
        }
        .link-item:hover {
            background-color: #F8F8F8;
        }
        form.logout-form {
            cursor: pointer;
        }
        form.logout-form a > span {
            color: #3D4953;
            line-height: 24px;
            font-weight: 500;
            font-size: 14px;
        }
        form.logout-form > a:hover {
            filter: invert(31%) sepia(72%) saturate(4355%) hue-rotate(204deg) brightness(105%) contrast(99%);
        }
        .avatar-link:hover div.dropDown-link {
            opacity: 1;
            transform: translateY(0);
        }
        .scroll-down {
            cursor: pointer;
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
        }
        .reactions {
            width: 32px;
            height: 32px;
            cursor: pointer;
        }
        .author {
            object-fit: cover;
        }
        @media (max-width: 991px) {
            .responsive-text {
                margin-left: 4px !important;
            }
        }
        @media (max-width: 900px) {
            .responsive-text {
                display: none !important;
            }
            .w-25 {
                width: 50% !important;
            }
            .add-new {
                width: 25%;
            }
        }
    </style>
    @stack('css')
</head>
<body>
    <div class="nav-bar d-flex justify-content-between sticky-top">
        <div class="d-inline-flex justify-content-start align-items-center w-25 position-relative position-left">
            <div class="d-flex justify-content-evenly align-items-center w-18 mr-3">
                <a href="{{ route('home') }}">
                    <img class="logo" src="{!! asset('/assets/images/square-dark-logo.svg') !!}" alt="doanxem.svg">
                </a>
{{--                <div>--}}
{{--                    <img src="{!! asset('/assets/images/buttons/caret-circle-down.svg') !!}" alt="caret-down.svg">--}}
{{--                </div>--}}
            </div>
            @if (request()->route()->getName() == 'home')
            <a class="d-inline-flex justify-content-evenly align-items-center w-18 mr-3 tab-active"
               href="{{route('home')}}">
                <img class="active" src="{!! asset('/assets/images/buttons/compact.svg') !!}" alt="newfeed">
                <p class="m-0 active responsive-text">Mới</p>
            </a>
            @else
                <a class="d-inline-flex justify-content-evenly align-items-center w-18 mr-3"
                   href="{{route('home')}}">
                    <img class="disabled" src="{!! asset('/assets/images/buttons/compact.svg') !!}" alt="newfeed">
                    <p class="m-0 disabled responsive-text">Mới</p>
                </a>
            @endif
            @if (request()->route()->getName() == 'top')
                <a class="d-inline-flex justify-content-evenly align-items-center w-18 mr-3 tab-active"
                   href="{{route('top')}}">
                    <img class="active" src="{!! asset('/assets/images/buttons/champ-cup.svg') !!}" alt="top">
                    <p class="m-0 active responsive-text">Top</p>
                </a>
            @else
            <a class="d-inline-flex justify-content-evenly align-items-center w-18 mr-3"
               href="{{route('top')}}">
                <img class="disabled" src="{!! asset('/assets/images/buttons/champ-cup.svg') !!}" alt="top">
                <p class="m-0 disabled responsive-text">Top</p>
            </a>
            @endif
            @if (request()->route()->getName() == 'hot')
                <a class="d-inline-flex justify-content-evenly align-items-center w-18 mr-3 tab-active"
                   href="{{route('hot')}}">
                    <img class="active" src="{!! asset('/assets/images/buttons/fire.svg') !!}" alt="hot">
                    <p class="m-0 active responsive-text">Hot</p>
                </a>
            @else
            <a class="d-inline-flex justify-content-evenly align-items-center w-18 mr-3"
               href="{{route('hot')}}">
                <img class="disabled" src="{!! asset('/assets/images/buttons/fire.svg') !!}" alt="hot">
                <p class="m-0 disabled responsive-text">Hot</p>
            </a>
            @endif
        </div>
        <div class="d-inline-flex justify-content-end align-items-center w-25 position-relative position-right">
{{--            <a href=" route to notification ">--}}
{{--                <img class="disabled" src="{!! asset('/assets/images/buttons/bell.svg') !!}" alt="bell">--}}
{{--            </a>--}}
            @auth
                <div class="avatar-link">
                    <a class="ml-1">
                        <img class="avatar" src="{{ auth()->user()->avatar }}" alt="avatar">
                    </a>
                    <div class="dropDown-link d-flex">
                        <form id="logout-form" class="logout-form link-item d-flex" method="post" action="{{ route('logout') }}">
                            @csrf
                            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img class="" src="{!! asset('/assets/images/buttons/SignOut.svg') !!}">
                                <span>Đăng Xuất</span>
                            </a>
                        </form>
                    </div>
                </div>

                <a  href="{{ route('get.addform',auth()->user()->user_uuid) }}"
                    class="ml-1 add-new d-flex align-items-center justify-content-evenly">
                    <img class="pen-plus"
                        src="{!! asset('/assets/images/buttons/pen-plus.svg') !!}"
                         alt="new-post">
                    <span class="responsive-text">Đăng bài</span>
                </a>

            @else
                <div class="avatar-link">
                    <a class="ml-1">
                        <img class="avatar" src="{!! asset('/assets/images/default-user.svg') !!}" alt="avatar">
                    </a>
                    <div class="dropDown-link d-flex">
                        <a class="link-item d-flex justify-content-evenly" href="{{ route('login') }}">
                            <img src="{!! asset('/assets/images/User.svg') !!}" alt="">
                            <span>Đăng Nhập</span>
                        </a>
                    </div>
                </div>
                <a class="ml-1 btn add-new d-flex align-items-center justify-content-evenly"
                   href="{{ route('login') }}">
                    <img class="pen-plus"
                        src="{!! asset('/assets/images/buttons/pen-plus.svg') !!}" alt="new-post">
                    <span class="responsive-text">Đăng bài</span>
                </a>
            @endauth
        </div>
    </div>
@yield('content')
<a class="scroll-down">
    <img src="{!! asset('/assets/images/buttons/CaretDoubleDown.svg') !!}" alt="">
    <span>Kéo xuống để tải thêm</span>
</a>
</body>
@stack('script')
</html>

