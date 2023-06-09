@extends('admin.layouts.app')
@section('page')
        <style>
            #dashboard-ecommerce {
                display: none;
            }
        </style>
    <div class="app-content content p-0">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">


            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Thông tin cá nhân</h4>
                            </div>
                            <div class="card-body py-2 my-25">
                                <!-- form -->
                                <form class="validate-form mt-2 pt-50 profile-detail">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="name">Họ và tên</label>
                                            <input type="text" class="form-control" id="name"
                                                   name="name" placeholder="Nhập họ và tên"
                                                   value="{{$user->name}}"
                                                   data-msg="Please enter first name"/>
                                        </div>
                                        <div class="col-12 col-sm-3 mb-1">
                                            <label class="form-label" for="accountEmail">Email</label>
                                            <input type="email" class="form-control" id="accountEmail" name="email"
                                                   placeholder="Email" value="{{$user->email}}"/>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary mt-1 me-1" id="save-profile">
                                                Lưu thay đổi
                                            </button>
                                            <button type="reset" class="btn btn-danger mt-1"
                                                    onclick="location.reload()">Hủy bỏ
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Đổi mật khẩu</h4>
                            </div>
                            <div class="card-body pt-1">
                                <!-- form -->
                                <form class="validate-form password-area">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1 ">
                                            <label class="form-label" for="account-old-password">Mật khẩu hiện
                                                tại</label>
                                            <div class="input-group form-password-toggle input-group-merge">
                                                <input type="password" class="form-control" id="account-old-password"
                                                       name="current_password" placeholder="Nhập mật khẩu hiện tại"
                                                       data-msg="Please current password"/>
                                                <div class="input-group-text cursor-pointer">
                                                    <i data-feather="eye"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="account-new-password">Mật khẩu mới</label>
                                            <div class="input-group form-password-toggle input-group-merge">
                                                <input type="password" id="account-new-password" name="new_password"
                                                       class="form-control" placeholder="Nhập mật khẩu mới"/>
                                                <div class="input-group-text cursor-pointer">
                                                    <i data-feather="eye"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="account-retype-new-password">Xác nhận mật
                                                khẩu</label>
                                            <div class="input-group form-password-toggle input-group-merge">
                                                <input type="password" class="form-control"
                                                       id="account-retype-new-password" name="confirm_password"
                                                       placeholder="Nhập mật khẩu xác nhận"/>
                                                <div class="input-group-text cursor-pointer"><i data-feather="eye"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="fw-bolder">Yêu cầu mật khẩu</p>
                                            <ul class="ps-1 ms-25">
                                                <li class="mb-50">Mật khẩu phải có ít nhất 6 kí tự</li>
                                            </ul>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary me-1 mt-1" id="save-password">
                                                Lưu thay đổi
                                            </button>
                                            <button type="reset" class="btn btn-danger mt-1">Hủy bỏ</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                        </div>
                        <!-- deactivate account  -->

                        <!--/ profile -->
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {
            const form = $('.profile-detail');
            $('#save-profile').on('click', function () {
                const data = getDataInForm(form, 'input');
                editProfile(data).then(resp => {
                    const {code, data, message} = resp.data;

                    if (code === ERROR) {
                        $.each(data, function (index, val) {
                            form.find('input[name=' + index + ']')
                                .addClass('is-invalid').parent().append('<div class="invalid-feedback">' +
                                '<strong>' + val[0] + '</strong>' +
                                '</div>');
                        });
                    }

                    if (code === SUCCESS) {
                        successAlert(message).then(() => {
                            location.reload();
                        })
                    }
                })
            })

            const formPassword = $('.password-area');
            $('#save-password').on('click', function () {
                hideValidation(formPassword, 'input');
                const data = getDataInForm(formPassword, 'input');
                editPassword(data).then(resp => {
                    const {code, data, message} = resp.data;

                    if (code === ERROR) {
                        $.each(data, function (index, val) {
                            formPassword.find('input[name=' + index + ']')
                                .addClass('is-invalid').parent().append('<div class="invalid-feedback">' +
                                '<strong>' + val[0] + '</strong>' +
                                '</div>');
                        });
                    }

                    if (code === SUCCESS) {
                        successAlert(message).then(() => {
                            formPassword.trigger('reset')
                        })
                    }
                })
            })
        })
    </script>
@endpush
