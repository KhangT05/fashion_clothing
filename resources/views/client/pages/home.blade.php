@extends('client.layouts')
@section('content')
    <div class="container my-5">
        <div id="carouselExampleCaptions" class="carousel slide mx-auto" style="max-width: 900px;">
            <div class="carousel-indicators">
                @foreach ($slide as $index => $item)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner rounded-3 shadow-lg">
                @foreach ($slide as $index => $item)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <a href="{{ $item->linklienket }}">
                            <img src="{{ $item->hinhthunho }}" class="d-block w-100"
                                style="height: 400px; object-fit: cover;" alt="{{ $item->tieude }}"></a>
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $item->tieude }}</h5>
                            <p>{{ $item->mota }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Sản Phẩm Mới -->
    @if (isset($sanphamMoi) && $sanphamMoi->count() > 0)
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 fw-bold text-dark">Sản Phẩm Mới</h2>
                <a href="{{ route('client.products.new') }}" class="text-decoration-none text-primary">
                    Xem tất cả <i class="fa fa-arrow-right"></i>
                </a>
            </div>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-2">
                @foreach ($sanphamMoi as $sp)
                    @include('client.components.product-card', ['product' => $sp])
                @endforeach
            </div>
        </div>
    @endif
    <!-- Danh Mục Sản Phẩm -->
    @if (isset($danhMucNoiBat) && $danhMucNoiBat->count() > 0)
        @foreach ($danhMucNoiBat as $category)
            @if ($category->sanphams && $category->sanphams->count() > 0)
                <div class="container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h3 fw-bold text-dark">{{ $category->name }}</h2>
                        <a href="{{ route('client.category.show', $category->slug) }}"
                            class="text-decoration-none text-primary">
                            Xem tất cả <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-2">
                        @foreach ($category->sanphams->take(10) as $sp)
                            @include('client.components.product-card', ['product' => $sp])
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    <div class="container py-4">
        <h1 class="h2 fw-bold mb-4 text-dark">Cửa Hàng</h1>
        <div class="d-flex flex-column gap-4">
            <div class="w-100">
                <div class="bg-white p-2 rounded shadow-sm mb-3 d-flex justify-content-between align-items-center">
                    <p class="text-secondary mb-0" style="font-size: 0.75rem;">
                        Hiển thị <span class="fw-semibold">{{ $sanpham->count() }}</span> sản phẩm
                    </p>
                    <form method="GET" action="{{ route('client.products.index') }}" class="d-inline">
                        <select name="sort" class="form-select form-select-sm" style="width: auto; font-size: 0.75rem;"
                            onchange="this.form.submit()">
                            <option value="">Sắp xếp mặc định</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp
                                đến
                                Cao</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao
                                đến
                                Thấp</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất
                            </option>
                        </select>
                    </form>
                </div>
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-2">
                    @forelse($sanpham as $sp)
                        @include('client.components.product-card', ['product' => $sp])
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Không có sản phẩm nào.</p>
                        </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $sanpham->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
