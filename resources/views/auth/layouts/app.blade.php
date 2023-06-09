<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="16x16">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="24x24">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="32x32">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="64x64">
    <link rel="icon" href="{!! asset('/assets/images/round-dark-logo.svg') !!}" type="image/x-icon" sizes="96x96">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @font-face {
            font-family: Averta-PE-Bold;
            src: url("{!! asset('/assets/font-family/Averta/Averta-PE/Averta-PE-Bold.otf') !!}");
        }
        body {
            font-family: Averta-PE-Bold, sans-serif;
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 20px;
        }
        .background {
            background-color: #f1f8ff;
            height: 100vh;
        }
        .nav-bar {
            height: 3.5rem;
            background-color: #FFFFFF;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            position: relative;
            left: 4rem;
            height: 40px;
            width: 40px;
            cursor: pointer;
        }
        img {
            width: 100%;
            height: 100%;
        }
        label img {
            width: 20px;
            height: 48px;
        }
        .group-buttons {
            position: absolute;
            right: 4rem;
            height: 34px;
            width: 300px;
            justify-content: space-around;
        }
        .btn {
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            width: 100px;
            border-radius: 4px;
        }
        .primary {
            color: #0177FD;
            opacity: 1 !important;
        }
        .form-wrapper {
            background-color: #FFFFFF;
            height: 95%;
            transform: translateY(2.5%);
            width: 80%;
            padding: 10%;
            border-radius: 10px;
            box-shadow: 0px 16px 32px rgba(47, 128, 237, 0.08);
        }
        .form-title {
            margin-bottom: 4rem;
        }
        .title {
            font-weight: 700;
            font-size: 18px;
            line-height: 24px;
            color: #0B2347;
        }
        .description {
            color: #7B7B7B;
            font-size: 14px;
            line-height: 20px;
            font-weight: 400;
        }
        .form-input {
            border: 1px solid #ECECEC;
            border-radius: 5px;
            height: 50px;
            display: flex;
            justify-content: space-around;
            margin-bottom: 16px;
        }
        .form-input > input {
            border: none;
            width: 80%;
            position: relative;
            left: -5%;
        }
        input {
            background-color: white;
            color: #3D4953;
            font-weight: 600;
            font-size: 14px;
        }
        input:focus-visible{
            outline: none;
        }
        ::placeholder {
            color: #ADADAD;
            font-size: 14px;
            line-height: 20px;
            font-weight: 600;
            font-style: normal;
        }
        .forgot-password {
            color: #4A4A4A;
            display: flex;
            width: 100%;
            justify-content: end;
        }
        .submit-button {
            height: 52px;
            margin-top: 1rem;
        }
        .submit-button > button {
            box-shadow: 0px 8px 16px rgba(47, 128, 237, 0.4);
            border-radius: 5px;
        }
        .form-footer {
            margin-top: 4rem;
        }
        .footer-title {
            text-align: center;
            display: flex;
            height: 3rem;
            align-content: center;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
        }
        .footer-title > p {
            color: #4A4A4A;
            font-size: 16px;
            line-height: 22px;
        }
        .social-login {
            height: 50px;
            width: 100%;
        }
        .social-button {
            width: 47%;
            border: 1px solid #ECECEC;
            border-radius: 6px;
            justify-content: center;
            align-content: center;
            align-items: center;
        }
        .social-button img {
            width: 20%;
            margin-right: 1rem;
        }
        .social-button span {
            color: #3D4953;
            font-weight: 700;
            font-size: 14px;
        }
        a {
            text-decoration: none;
            cursor: pointer;
        }
        .register {
            text-align: center;
            margin-top: 5rem;
        }
        .register > span {
            color: #3D4953;
            font-size: 16px;
            line-height: 22px;
            font-weight: 400;
        }
        @media (max-width: 991px) {
            .form-wrapper {
                width: 100%;
            }
        }
        @media (max-width: 500px) {
            .forgot-password {
                left: 50%;
            }
            .nav-bar {
                justify-content: center !important;
            }
            .logo {
                left: 0;
            }
            .group-buttons {
                display: none !important;
            }
            .social-button img{
                margin-right: 0;
            }
        }
    </style>
    @stack('style')
</head>
<body>
    @yield('content')
</body>
<script>
    function redirectTo(url) {
        window.location.href = url;
    }
</script>
</html>
