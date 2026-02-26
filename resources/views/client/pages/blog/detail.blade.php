@extends('client.layouts') {{-- Hoặc file layout chính của bạn --}}
@section('title', 'Trang chi tiết bài viết')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Ảnh bài viết --}}
                <img src="{{ Str::startsWith($post->image_url, 'http') ? $post->image_url : asset('storage/' . $post->image_url) }}"
                    alt="Ảnh bài viết" class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;">

                {{-- Tiêu đề --}}
                <h1 class="fw-bold mb-3">{{ $post->title }}</h1>

                {{-- Thông tin phụ --}}
                <div class="text-muted mb-4">
                    <span><i class="fa fa-calendar"></i> {{ $post->created_at->format('d/m/Y') }}</span>
                </div>

                {{-- Nội dung chi tiết --}}
                <div class="content">
                    {!! $post->content !!}
                </div>

                <hr>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection
