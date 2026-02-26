<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('server.layouts') }}">Trang chủ</a></li>
        {{-- @foreach ($breadcrumb as $item)
            <li class="breadcrumb-item"><a href="{{ route($item['route']) }}">{{ $item['title'] }}</a></li>
        @endforeach --}}
    </ol>
</nav>

<style>
    .breadcrumb {
        background: #f8f9fa;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .breadcrumb-item a:hover {
        color: #0d6efd;
    }

    .breadcrumb-item.active {
        color: #495057;
        font-weight: 500;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        color: #adb5bd;
    }
</style>
