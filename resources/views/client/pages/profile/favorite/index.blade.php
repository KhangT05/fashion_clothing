@extends('client.layouts')
@section('title', 'Trang yêu thích')
@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- PHẦN 1: MENU BÊN TRÁI (Giống các trang profile khác) --}}
            <div class="col-md-3">
                @include('client.pages.profile.layout_menu')
            </div>
            {{-- PHẦN 2: NỘI DUNG SẢN PHẨM YÊU THÍCH (Bên phải) --}}
            <div class="col-md-9">
                <h3 class="mb-4">Sản phẩm yêu thích của bạn</h3>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            @forelse($favorite as $item)
                                <div class="col-md-4 mb-4"> {{-- Đổi col-md-3 thành col-md-4 vì không gian hẹp hơn --}}
                                    <div class="card h-100">
                                        {{-- Kiểm tra xem sản phẩm có ảnh không để tránh lỗi --}}
                                        <img src="{{ $item->hinhnen ?? asset('path/to/default-image.jpg') }}"
                                            class="card-img-top" alt="{{ $item->tensp }}"
                                            style="height: 200px; object-fit: cover;">

                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title" style="font-size: 1rem;">
                                                {{ Str::limit($item->tensp, 40) }}</h5>
                                            <p class="card-text text-danger font-weight-bold">
                                                {{-- @foreach ($item as $variant) --}}
                                                {{ number_format($item->giaban) }} VNĐ
                                                {{-- @endforeach --}}
                                            </p>

                                            <div class="mt-auto">
                                                <button
                                                    class="btn btn-light btn-sm rounded-circle position-absolute top-0 start-0 m-1 opacity-0 hover:opacity-100 transition-opacity"
                                                    onclick="toggleFavorite({{ $item->id }})">
                                                    <i class="fa fa-heart text-danger" style="font-size: 12px;">Bỏ thích</i>
                                                </button>
                                                {{-- Có thể thêm nút xem chi tiết nếu cần --}}
                                                <a href="{{ route('client.products.index') }}"
                                                    class="btn btn-primary btn-sm btn-block mt-2">
                                                    Xem chi tiết
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <p class="text-muted">Bạn chưa có sản phẩm yêu thích nào.</p>
                                    <a href="{{ route('client.products.index') }}" class="btn btn-primary">Khám phá sản phẩm
                                        ngay</a>
                                </div>
                            @endforelse
                        </div>

                        {{-- Phân trang --}}
                        <div class="d-flex justify-content-center mt-3">
                            {{ $favorite->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function toggleFavorite(productId) {
            fetch(`/profile/favorite/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    // Kiểm tra nếu redirect (302)
                    if (response.redirected) {
                        window.location.href = response.url;
                        return;
                    }
                    // Kiểm tra content-type
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        return response.text().then(text => {
                            console.error('Response không phải JSON:', text);
                            throw new Error('Server không trả về JSON');
                        });
                    }
                })
                .then(data => {
                    if (data && data.success) {
                        alert(data.message);
                        // Có thể toggle icon tim ở đây
                        location.reload(); // Reload để cập nhật UI
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                });
        }
    </script>
@endpush
