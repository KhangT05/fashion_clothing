<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
    @stack('head')
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-200">
    <div id="wrapper" class="flex h-screen">
        @include('server.components.sidebar')
        <div id="page-wrapper" class="flex-1 flex flex-col overflow-hidden">
            @include('server.components.nav')
            <div class="flex-1 overflow-y-auto">
                <div class="container mx-auto px-4 py-6 max-w-7xl">
                    {{-- @include('server.components.breadcrumb') --}}
                    @yield('content')
                </div>
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
