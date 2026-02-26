@extends('client.layouts')
@section('title', 'Trang đánh giá')
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-3">
                @include('client.pages.profile.layout_menu')
            </div>
            <div class="col-md-9">
                <h3 class="mb-4">Lịch sử đánh giá sản phẩm</h3>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @if ($reviews->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-muted">Bạn chưa đánh giá sản phẩm nào.</p>
                                <a href="{{ route('products') }}" class="btn btn-primary">Mua sắm ngay</a>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach ($reviews as $review)
                                    <div class="list-group-item p-3">
                                        <div class="d-flex w-100 justify-content-between">
                                            {{-- Tên sản phẩm & Link --}}
                                            <h5 class="mb-1">
                                                <a href="#" class="text-decoration-none text-dark">
                                                    {{ $review->sanpham->name ?? 'Sản phẩm không tồn tại' }}
                                                </a>
                                            </h5>
                                            <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                        </div>

                                        {{-- Số sao đánh giá --}}
                                        <div class="mb-2 text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa {{ $i <= $review->stars ? 'fa-star' : 'fa-star-o' }}"></i>
                                            @endfor
                                        </div>

                                        {{-- Nội dung bình luận --}}
                                        <p class="mb-1 text-muted">{{ $review->noidung }}</p>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Phân trang --}}
                            <div class="mt-3">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
