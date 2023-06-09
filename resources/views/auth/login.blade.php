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
        <div class="container d-flex flex-row-reverse p-0">
            <div class="col-12 col-lg-6">
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
                            <a class="forgot-password" href="{{ route('password.request') }}">Quên mật khẩu</a>
                            <div class="submit-button">
                                <button type="submit" class="btn btn-primary w-100 h-100">Vào cổng chính</button>
                            </div>
                        </form>
                    </div>
                    <div class="form-footer">
                        <div class="footer-title">
                            <p class="m-0">Hoặc thử trèo tường</p>
                        </div>
                        <div class="social-login d-inline-flex justify-content-between">
                            <a class="d-inline-flex social-button" href="{{ route('social.login',$social = 'google') }}">
                                <img src="{!! asset('/assets/images/google.svg') !!}" alt="google.svg">
                                <span>Google</span>
                            </a>
                            <a class="d-inline-flex social-button" href="{{ route('social.login',$social = 'facebook') }}">
                                <img src="{!! asset('/assets/images/facebook.svg') !!}" alt="facebook.svg">
                                <span>Facebook</span>
                            </a>
                        </div>
                        <div class="register">
                            <span>Chưa có tài khoản? </span>
                            <a class="primary" href="{{ route('register') }}">Đăng ký</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <img src="{!! asset('/assets/images/auth-background.svg') !!}" alt="background">
            </div>
        </div>
    </div>
@endsection
