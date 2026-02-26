<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link href="{{ asset('server/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
        rel="stylesheet">
    <link href="{{ asset('server/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('server/css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('server/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('server/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('server/library/customzime.css') }}" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        @include('server.components.sidebar')
        <div id="page-wrapper" class="gray-bg">
            @include('server.components.nav')
            <div class="wrapper wrapper-content">
                {{-- @include('server.components.breadcrumb') --}}
                @yield('content')
            </div>
            @include('server.components.footer')
        </div>
    </div>
    @include('server.components.script')
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
    @stack('scripts')
</body>

</html>
