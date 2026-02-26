@extends('client.layouts')
@section('title', 'Trang sản phẩm mới')
@section('title', 'Sản phẩm mới')

@section('content')
    <div class="container my-4">
        <h2 class="mb-4">Sản phẩm mới</h2>

        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <a href="{{ url('san-pham/' . $product->slug) }}">
                            <img src="{{ $product->hinhnen }}" class="card-img-top" alt="{{ $product->tensp }}">
                        </a>

                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ url('san-pham/' . $product->slug) }}">
                                    {{ $product->tensp }}
                                </a>
                            </h6>

                            <p class="text-danger fw-bold">
                                {{ number_format($product->giaban) }} đ
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p>Chưa có sản phẩm mới</p>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
