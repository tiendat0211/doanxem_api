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
        .responsive-div {
            margin: 40px 0;
            height: 100vh;
            position: relative;
            left: 25%;
            padding: 0 2rem 2rem 2rem;
            background-color: white;
        }
        .head-card {
            border-bottom: 2px solid #DEE9FA;
            width: calc(100% + 4rem);
            position: relative;
            right: 2rem;
            padding: 0 2rem;
        }
        .title {
            margin: 0 !important;
            font-size: 20px;
            font-weight: 700;
            line-height: 28px;
            color: #0B2347;
        }
        .body-card {
            margin-top: 2rem;
        }
        .header-form {
            font-weight: 700;
            font-size: 14px;
            line-height: 20px;
            color: #3D4953;
            width: 100%;
        }
        form#my-drop {
            border: 2px dashed #ECECEC;
            border-radius: 8px;
            height: 285px;
            position: relative;
        }
        .fallback {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .fallback > input {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 5;
        }
        .icon-add-image {
            position: absolute;
            left: 47%;
            top: 40%;
            width: 43px;
            height: 43px;
            border-radius: 50%;
            background-color: #F2F8FF;
            cursor: pointer;
            z-index: 6;
        }
        .fallback > p {
            margin: 0;
            font-size: 14px;
            line-height: 20px;
            font-weight: 600;
            color: #7B7B7B;
            position: absolute;
            left: 43%;
            top: 55%;
        }
        .dz-default.dz-message {
            height: 100%;
        }
        .dz-button {
            width: 100%;
            height: 100%;
            font-weight: 600;
            font-size: 14px;
            line-height: 20px;
            color: #7B7B7B;
            background-color:white;
            padding: 0;
            outline-color: rgba(0,0,0,0);
            border: 1px solid rgba(0,0,0,0);
        }
        .dz-add-image-icon {
            position: absolute;
            left: 49%;
            top: 37%;
        }
        .dz-preview {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 6;
        }
        .dz-image {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
        }
        .dz-image > img {
            height: 100%;
        }
        .dz-details {
            display: none;
        }
        .dz-progress {
            height: 5%;
        }
        .dz-success-mark, .dz-error-mark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
        .error-message {
            color: darkred;
            text-align: center;
            position: relative;
            left: 50%;
            transform: translate(-70%);
        }
        .dz-remove {
            height: 32px;
            width: 32px;
            position: absolute;
            top: 12px;
            right: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0,0,0,0.05);
            border-radius: 50%;
        }
        .dz-remove > img {
            width: 20px;
            height: 20px;
        }
        .re-upload {
            text-align: center;
            font-size: 12px;
            font-weight: 400;
            line-height: 18px;
            color: #ADADAD;
            margin-top: 12px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .re-upload:hover {
            color: #0e6dcd;
        }
        .horizon-break-line {
            width: 100%;
            height: 1px;
            background-color: #ECECEC;
        }
        form#my-post {
            margin-top: 20px;
        }
        label[for="title"] {
            width: 100%;
            font-size: 14px;
            line-height: 20px;
            font-weight: 700;
            color: #3D4953;
            margin-bottom: 8px;
        }
        #title {
            width: 100%;
            height: 88px;
            outline: none;
            border: none;
            color: #7B7B7B;
            resize: none;
            font-weight: 400;
        }
        form#my-post > button {
            width: 100%;
            height: 50px;
            border-radius: 8px;
            color: white;
        }

    </style>
@endpushonce
@section('content')
    <div class="container-fluid">
        <div class="col-6 responsive-div">
            <div class="d-flex justify-content-between align-items-center head-card">
                <p class="title">Mang vui vẻ tới cho đời</p>
                <img src="{!! asset('/assets/images/emojis/in-love-chick.svg') !!}" alt="lovely-chick">
            </div>
            <div class="body-card">
                <div class="d-inline-flex justify-content-start header-form">
                    <p>Media</p>
                    <p class="error-message"></p>
                </div>
                <form
                    id="my-drop"
                    method="post"
                    class="dropzone"
                    action="/member/user/{{ auth()->user()->user_uuid }}/post-file-url"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="fallback">
                        <div onclick="addImage()"
                            class="icon-add-image d-flex align-items-center justify-content-center">
                            <img src="{!! asset('/assets/images/buttons/addimage.svg') !!}" alt="addimage">
                        </div>
                        <p>Thêm ảnh/video</p>
                        <input id="file-upload" name="file" type="file" placeholder="Thêm ảnh/video"/>
                    </div>
                    <img class="dz-add-image-icon" src="{!! asset('/assets/images/buttons/addimage.svg') !!}" alt="addimage">
                </form>
                <div class="re-upload">Bạn có thể tải lại</div>
                <div class="horizon-break-line"></div>
            </div>
            <form
                id="my-post"
                method="post"
            >
                @csrf
                <label for="title">
                    Mô tả
                </label>
                <textarea
                    rows="4"
                    id="title"
                    name="title"
                    type="text"
                    placeholder="Kể về niềm vui của bạn đi"
                ></textarea>
                <div class="horizon-break-line mb-3"></div>
                <input name="thumbnail" type="hidden" >
                <input name="image_uuid" type="hidden" >
                <input name="image_url" type="hidden" >
                <button>Đăng luôn cho nóng</button>
            </form>
        </div>
    </div>
@endsection
@pushonce('script')
    <script>
        $(function() {
            let reUpload = $('.re-upload');
            let thumbnail = $('#my-post > input[name="thumbnail"]');
            let image_url = $('#my-post > input[name="image_url"]');
            let image_uuid = $('#my-post > input[name="image_uuid"]');
            let submitButton = $('#my-post > button');
            let title = $('#title');
            let error = $('.error-message');
            console.log(submitButton);
            title.val('');
            image_url.val('');
            image_uuid.val('');
            thumbnail.val('');
            submitButton.attr('disabled',true);
            submitButton.css('background-color','#86B8F1')
            if (window.Dropzone === undefined) {
                let inputUpload = $('#file-upload');
                $('.dz-add-image-icon').css('display','none');
                reUpload.on('click',function () {
                    inputUpload.val('');
                    inputUpload.click();
                })
            }
                let myDropzone = new Dropzone('form#my-drop', {
                    dictDefaultMessage: 'Thêm ảnh/video',
                    maxFiles: 1,
                    acceptedFiles: 'image/*,.gif,.mp4,.avi,.wmv,.mov,.flv,.ts,.m3u8,.webm',
                    maxFilesize: 10,
                    url: "/member/user/{{ auth()->user()->user_uuid }}/post-file-url",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    autoProcessQueue: true,
                    uploadMultiple: false,
                    addRemoveLinks: true,
                    thumbnailWidth: 200,
                    thumbnailHeight: 200,
                    dictRemoveFile: `<img src='{!! asset('/assets/images/buttons/x.svg') !!}' alt='x'>`,
                    dictCancelUpload: `<img src='{!! asset('/assets/images/buttons/x.svg') !!}' alt='x'>`,
                    init: function () {
                        this.on("addedfile", function (file) {
                            $('.dz-success-mark').hide();
                            $('.dz-error-mark').hide();
                            $('.error-message').hide();
                            if (file.type.match(/video.*/)) {
                                let fileUrl = URL.createObjectURL(file);
                                $(file.previewElement).find('.dz-image').html(`
                                    <video id="preview-video" controls></video>
                                `);
                                $('#preview-video')[0].src= fileUrl;
                            }
                            $('.dz-remove').on('click',function () {
                                image_url.val('');
                                image_uuid.val('');
                                thumbnail.val('');
                            });
                        })
                        this.on("maxfilesexceeded", function(file) {
                            this.removeAllFiles();
                            thumbnail.val('')
                            image_url.val('')
                            image_uuid.val('')
                            this.addFile(file);
                        })
                        this.on("success", async function (file, response) {
                            let successMark = $(file.previewElement).find('.dz-success-mark');
                            successMark.fadeIn();
                            successMark.fadeOut();
                            thumbnail.val(response.data.thumbnail_url)
                            image_url.val(response.data.image_url)
                            image_uuid.val(response.data.image_uuid)
                        })
                        this.on("error", async function (file, response) {
                            let errorMark = $(file.previewElement).find('.dz-error-mark');
                            errorMark.fadeIn();
                            errorMark.fadeOut();
                            thumbnail.val('')
                            image_url.val('')
                            image_uuid.val('')

                            $(file.previewElement).find('.dz-image').css('border', '1px dashed red');
                            if (file.size > 10 * 1024 * 1024) {
                                error.html('Hàng của bạn to quá thử cái khác đi chỉ 10mb thôi');
                            }
                            if (!file.type.match(/image.*/) || !file.type.match(/video.*/)) {
                                error.html('Hàng cấm xin hãy thử lại');
                            }
                            error.show();
                            this.removeAllFiles();
                        })
                    }
                });
            reUpload.on('click',function () {
                myDropzone.removeAllFiles();
                thumbnail.val('')
                image_url.val('')
                image_uuid.val('')
                $('.dz-button').click();
            });
            title.on('input',function() {
                submitButton.removeAttr('disabled');
                submitButton.css('background-color','#177FDD');
                if($(this).val() === '') {
                    submitButton.attr('disabled',true);
                    submitButton.css('background-color','#86B8F1');
                }
            })
            $('#my-post').on('submit',function (e) {
                e.preventDefault();
                if (!image_url.val() || !image_uuid.val()) {
                    error.html('bạn phải đợi file tải lên đã');
                    return error.show();
                }
                let content = title.val();
                title.val('');
                $.ajax({
                    url: "/member/user/{{ auth()->user()->user_uuid }}/create-post",
                    data: {
                        image: image_url.val(),
                        title: content,
                        thumbnail: thumbnail.val(),
                        uuid: image_uuid.val()
                    },
                    method: "post",
                    beforeSend: function(request) {
                        request.setRequestHeader('X-CSRF-TOKEN','{{ csrf_token() }}')
                    }
                }).done(response => {
                    if (!response) return;
                    alert('Đăng thành công');
                    myDropzone.removeAllFiles();
                }).fail(error => {
                    alert('Đăng thất bại');
                    myDropzone.removeAllFiles();
                });
            })
        });
        function addImage(){
            document.getElementById('file-upload').click();
        }
    </script>
@endpushonce
