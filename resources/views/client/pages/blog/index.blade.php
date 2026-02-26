@extends('client.layouts')
@section('title', 'Trang bài viết')
@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Tin tức công nghệ</h2>

            {{-- FORM TÌM KIẾM (REQ 23) --}}
            <form action="{{ route('blog') }}" method="GET" class="d-flex">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm kiếm bài viết..."
                    value="{{ request()->keyword }}">
                <button class="btn btn-primary" type="submit">Tìm</button>
            </form>
        </div>

        <div class="row">
            @if ($posts->count() > 0)
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            {{-- Ảnh bài viết (Dùng ảnh mặc định nếu chưa có) --}}
                            <img src="{{ $post->image ?? 'https://via.placeholder.com/350x200' }}" class="card-img-top"
                                alt="{{ $post->title }}">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('blog.detail', $post->id) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($post->title, 50) }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted">{{ Str::limit($post->summary, 80) }}</p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="{{ route('blog.detail', $post->id) }}" class="btn btn-sm btn-outline-primary">Xem
                                    chi tiết</a>
                                <small class="text-muted float-end mt-1">{{ $post->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p>Không tìm thấy bài viết nào phù hợp.</p>
                </div>
            @endif
        </div>

        {{-- PHÂN TRANG (REQ 23) --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->appends(request()->all())->links() }}
            {{-- appends: Giữ lại từ khóa tìm kiếm khi chuyển trang --}}
        </div>
    </div>
@endsection
