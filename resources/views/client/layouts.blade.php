<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trang chủ')</title>
    <link href="{{ asset('server/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('client/css/owl.carousel.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('client/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    {{-- Thêm vite cho js --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('client/library/customzime.css') }}">
    <link rel="stylesheet" href="{{ asset('client/library/chat.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    @include('client.components.nav')
    @yield('content')
    @include('client.components.footer')
    @include('client.components.scripts')
    @stack('scripts')
</body>

</html>
