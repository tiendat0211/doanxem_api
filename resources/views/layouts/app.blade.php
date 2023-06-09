<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content='Trở thành meme của đoán xem để mở ra "trân trời" mới'>
        <meta name="keywords" content="register doanxem,rdx,đăng ký đoán xem,đk đx,đx">
        <meta name="author" content="sPhoton">
        <meta property="og:description" content='Trở thành meme của đoán xem để mở ra "trân trời" mới'>
        <meta property="og:type" content="website">
        <meta property="og:image" content="{!! asset('theme/images/Logodoanxem.png') !!}">
        <meta property="og:locale" content="vi">
        <title>Đoán Xem</title>
        <link rel="icon" href="{!! asset('theme/images/Logodoanxem.png') !!}" type="image/x-icon" sizes="16x16">
        <link rel="icon" href="{!! asset('theme/images/Logodoanxem.png') !!}" type="image/x-icon" sizes="24x24">
        <link rel="icon" href="{!! asset('theme/images/Logodoanxem.png') !!}" type="image/x-icon" sizes="32x32">
        <link rel="icon" href="{!! asset('theme/images/Logodoanxem.png') !!}" type="image/x-icon" sizes="64x64">
        <link rel="icon" href="{!! asset('theme/images/Logodoanxem.png') !!}" type="image/x-icon" sizes="96x96">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
