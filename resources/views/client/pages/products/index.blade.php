@extends('client.layouts')
@section('title', 'Trang sản phẩm')
@section('content')
    <div class="container py-4">
        <h1 class="h2 fw-bold mb-4 text-dark">Cửa Hàng</h1>
        @include('client.pages.products.components.shop-filter')
        <div class="d-flex flex-column gap-4">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-2">
                @forelse($product as $sp)
                    @include('client.components.product-card', ['product' => $sp])
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Không có sản phẩm nào.</p>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $product->links() }}
            </div>
        </div>
    </div>
@endsection
