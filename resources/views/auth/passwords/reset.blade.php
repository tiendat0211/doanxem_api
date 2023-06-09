@extends('layouts.app')

@section('css')
    <style>
        .input-item {
            border-radius: 2px !important;
            border: 2px #e6e6e6 solid;
        }

        .search-form {
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 200px">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror input-item"
                                       name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror input-item"
                                       name="password" required autocomplete="new-password" placeholder="Mật khẩu">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control input-item" name="password_confirmation"
                                       required autocomplete="new-password" placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    {{ __('Xác nhận') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
