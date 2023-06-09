@extends('auth.layouts.app')
@push('meta')
    <meta name="description" content='Trở thành meme của đoán xem để mở ra "trân trời" mới'>
    <meta name="keywords" content="register doanxem,rdx,đăng ký đoán xem,đk đx,đx">
    <meta name="author" content="sPhoton">
    <meta property="og:url" content="{{ route('login') }}">
    <meta property="og:title" content="Đăng nhập">
    <meta property="og:description" content='Trở thành meme của đoán xem để mở ra "trân trời" mới'>
    <meta property="og:type" content="website">
    <meta property="og:image" content="{!! asset('theme/images/Logodoanxem.png') !!}">
    <meta property="og:locale" content="vi">
    <title>Đăng nhập</title>
@endpush
@pushonce('style')
    <style>
        .form-wrapper {
            margin: 50px;
            padding: 10%;
            width: 100%;
        }
        .termOfUse > a {
            color: #5191F0 !important;
        }
        .form-footer > a {
            color: #0177FD !important;
        }
        span {
            color: #3D4953;
        }
    </style>
@endpushonce
@section('content')
    <div class="background">
        <div class="nav-bar d-flex">
            <div class="logo" onclick="redirectTo('{{ route('home') }}')">
                <img src="{!! asset('/assets/images/square-dark-logo.svg') !!}" alt="doanxem.sv">
            </div>
            <div class="group-buttons d-flex">
                <button class="btn primary" disabled>Đăng nhập</button>
                <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
            </div>
        </div>
        <div class="container d-flex flex-wrap p-0">
            <div class="row">
                <div class="col-12 col-md-7">
                    <img src="{!! asset('/assets/images/auth-background.svg') !!}" alt="background">
                </div>
                <div class="col-md-4">
                    <div class="form-wrapper">
                        <div class="form-title">
                            <p class="title">Chào đồng chí đến với đoán xem</p>
                            <p class="description">Báo danh để "sướng"</p>
                        </div>
                        <div class="form-body">
                            <form action="{{ route('login') }}" method="post" class="main-form">
                                @csrf
                                <div class="form-input d-flex">
                                    <label class="d-inline-flex" for="email">
                                        <img src="{!! asset('/assets/images/User.svg') !!}" alt="User.svg">
                                    </label>
                                    <input name="email" id="email" placeholder="Tên hiển thị">
                                </div>
                                <div class="form-input d-flex">
                                    <label class="d-inline-flex" for="email">
                                        <img src="{!! asset('/assets/images/mail.svg') !!}" alt="email.svg">
                                    </label>
                                    <input name="email" id="email" placeholder="Email">
                                </div>
                                <div class="form-input d-flex">
                                    <label class="d-inline-flex" for="password">
                                        <img src="{!! asset('/assets/images/lock.svg') !!}" alt="lock.svg">
                                    </label>
                                    <input name="password" id="password" type="password" placeholder="Mật Khẩu">
                                </div>
                                <div class="form-input d-flex">
                                    <label class="d-inline-flex" for="password">
                                        <img src="{!! asset('/assets/images/lock.svg') !!}" alt="lock.svg">
                                    </label>
                                    <input name="password" id="password" type="password" placeholder="Mật Khẩu">
                                </div>
                                <div class="d-flex justify-content-between align-content-center align-items-center">
                                    <input type="checkbox">
                                    <div class="termOfUse">
                                        <span>Xác nhận đồng ý với </span>
                                        <a>Điều khoản sử dụng</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-3">
                                    Đăng Ký
                                </button>
                            </form>
                        </div>
                        <div class="form-footer d-flex align-items-center justify-content-center">
                            <span>Đã có tài khoản?</span>
                            <a href="{{ route('login') }}">Đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <script>--}}
{{--        (() => {--}}
{{--            let checkbox = document.querySelector('input[type="checkbox"]');--}}
{{--            let button = document.querySelector('button[type="submit"]');--}}
{{--            checkbox.checked ?  button.removeClass('disabled') : button.addClass('disabled');--}}
{{--        })()--}}
{{--    </script>--}}
@endsection
