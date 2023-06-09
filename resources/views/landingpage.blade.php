<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:url" content="https://doanxem.com">
    <meta property="og:title" content="Ứng dụng giải trí siêu cấp">
    <meta property="og:site_name" content="Đoán Xem">
    <meta property="og:description" content="Thả mình vào thế giới bao quanh, đắm chìm vào không gian của những video và meme hài chất như nước cất">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{!! asset('/assets/images/land-image.png') !!}">
    <meta property="og:locale" content="vi">
    <title>Đoán Xem</title>
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="16x16">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="24x24">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="32x32">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="64x64">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="96x96">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @font-face {
            font-family: Averta-PE-Bold;
            src: url("{!! asset('/assets/font-family/Averta/Averta-PE/Averta-PE-Bold.otf') !!}");
        }
        body {
            font-family: Averta-PE-Bold, sans-serif;
            font-size: 16px;
            line-height: 22px;
            color: #4A4A4A;;
            font-weight: 400;
        }
        .line-height {
            height:40px;
            background-color: #0177FD;
            text-align: center;
            width: 100vw;
            justify-content: center;
            align-items: center;
        }
        .background {
            width: 100vw;
            height: 100vh;
            background-image: url("{!! asset('/assets/images/landing-page.jpg') !!}");
            background-repeat: no-repeat;
            background-position: top right;
            background-size: contain;
        }
        .ml-1 {
            margin-left: 1rem;
        }
        .mt-15 {
            margin-top: 15rem;
        }
        .mb-2 {
            margin-bottom: 2rem;
        }
        .pl-5 {
            padding-left: 5rem;
        }
        .pr-0 {
            padding-right: 0;
        }
        /*.vh-100 {*/
        /*    height: 100vh;*/
        /*}*/
        .title {
            margin-top: 2rem;
            font-size: 40px;
            line-height: 130%;
            color: #0B2347;
            font-weight: 700;
            width: 48%;
        }
        .position-div {
            position: absolute;
            top: 21%;
        }
        .position-img {
            width: 6rem;
        }
        .logo {
            width: 100%;
            height: 100%;
        }
        .description {
            width: 46%;
            font-weight: 400;
            line-height: 22px;
            color: #7B7B7B;
        }
        .link-app {
            width: 48%;
            height: 4rem;
            margin-top: 5rem;
            /*background-color: black;*/
        }
        .custom-text {
            color: #4A4A4A;
            width: 24%;
            text-align: start;
        }
        .button-app {
            height: 66%;
            display: flex;
            justify-content: center;
            align-content: center;
        }
        .img-padding {
            padding-right: 0.5rem;
            padding-left: 0.5rem;
        }
        .w-per-100 {
            width: 100%;
        }
        @media (max-width: 991px) {
            .background {
                background-image: url("{!! asset('/assets/images/landing-background-tablet.jpg') !!}");
                background-size: cover;
                background-repeat: no-repeat;
            }
            .custom-text {
                display: none;
            }

            .responsive-container {
                margin: 0;
                padding: 0;
            }
            .position-div {
                top: 31%;
                flex-direction: column;
                display: flex;
                align-content: center;
                align-items: center;
                justify-content: center;
            }
            .title {
                text-align: center;
            }
            .description {
                text-align: center;
            }
            .link-app {
                margin-top: 2rem;
            }
            .responsive-foot {
                margin-top: 3rem;
            }
        }
        @media (max-width: 768px) {
            .background {
                background-image: url("{!! asset('/assets/images/landing-background-mobile.jpg') !!}");
                background-repeat: no-repeat;
                background-size: cover;
            }
            .title {
                width: 75%;
            }
            .description {
                width: 70%;
            }
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="d-inline-flex bg-primary line-height">
            <img src="{!! asset('/assets/images/pepe-frog.svg') !!}" alt="pepe-frog">
            <div class="text-white ml-1">
                <a class="text-white" href="{{ route('home') }}">Ấn vào đây</a> để chill ngay
            </div>
        </div>
        <div class="container-fluid pr-0 pl-5 responsive-container">
            <div class="col-12 col-lg-4">
                <div class="position-div">
                    <div class="position-img">
                        <img class="logo" src="{!! asset('/assets/images/square-dark-logo.svg') !!}" alt="đoán xem">
                    </div>
                    <div class="title">
                        <p>
                            Siêu cấp ứng dụng giải trí Đoán Xem
                        </p>
                    </div>
                    <div class="description">
                        <p>
                            Thả mình vào thế giới bao quanh, đắm chìm vào không gian của những video và meme hài chất như nước cất
                        </p>
                    </div>
                    <div class="link-app d-grid">
                        <div class="row align-items-center justify-content-center align-content-center">
                            <div class="col-4 align-middle custom-text">
                                Tải xuống
                            </div>
                            <a class="button-app col-6 col-lg-4">
                                <img class="w-per-100" src="{!! asset('/assets/images/ch-play-button.svg') !!}" alt="ch-play" />
                            </a>
                            <a class="button-app col-6 col-lg-4">
                                <img class="w-per-100" src="{!! asset('/assets/images/app-store-button.svg') !!}" alt="app-store" />
                            </a>
                        </div>
                    </div>
                    <div class="mt-15 mb-2 d-flex responsive-foot">
                        <p>
                            Made with <img class="img-padding" src="{!! asset('/assets/images/heart.svg') !!}" alt="heart"> by sPhoton
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
