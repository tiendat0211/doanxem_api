@extends('layouts.app')

@section('css')
    <style>
        .upload-item {
            display: none;
        }

        .search-form {
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 200px">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Xác thực địa chỉ email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Đường dẫn xác thực đã được gửi đến email của bạn.') }}
                        </div>
                    @endif

                    {{ __('Trước khi đăng nhập, vui lòng mở email để xác thực.') }}
                    {{ __('Nếu bạn chưa nhận được email') }}, <a href="{{ route('verification.resend') }}">{{ __('ấn vào đây để gửi lại') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
