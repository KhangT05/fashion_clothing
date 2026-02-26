@extends('client.layouts')
@section('content')
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->tensp }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- anh san pham -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="{{ asset('client/img/' . basename($product->hinhnen)) }}" class="img-fluid rounded main-image"
                        id="mainImage" alt="{{ $product->tensp }}">
                </div>
            </div>
            <!-- thong tin chi tiet  -->
            <div class="col-md-6">

                <h1 class="h2 fw-bold text-uppercase">{{ $product->tensp }}</h1>
                <div class="product-info">

                    <p class="text-muted">
                        Sku: <span id="display-sku" class="fw-semibold">{{ $product->variants->first()->sku }}</span>
                    </p>

                    <p id="display-stock-info" class="text-muted">
                        Hiện tại còn <span id="display-stock-count"
                            class="fw-bold">{{ $product->variants->sum('soluong') }}</span> sản phẩm.
                    </p>
                    <h2 id="display-price" class="text-danger fw-bold mb-3">
                        {{ number_format($product->variants->first()->giaban, 0, ',', '.') }}đ
                    </h2>


                    <div class="product-variants mt-4">
                        <h6>Chọn kích thước:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            {{-- Lọc các biến thể để chỉ lấy các giá trị Size duy nhất dựa trên SKU --}}
                            @foreach ($product->variants->unique(function ($item) {
            return Str::afterLast($item->sku, '-');
        }) as $variant)
                                <button type="button" class="btn btn-outline-dark variant-select"
                                    data-sku="{{ $variant->sku }}"
                                    data-price="{{ number_format($variant->giaban, 0, ',', '.') }}đ"
                                    data-stock="{{ $variant->soluong }}">
                                    {{ Str::afterLast($variant->sku, '-') }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- thanh toan -->
                <form action="#" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex align-items-center mb-4">
                        <div class="input-group me-3" style="width: 130px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)">-</button>
                            <input type="text" class="form-control text-center" value="1" id="quantity"
                                name="quantity">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)">+</button>
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg flex-grow-1 text-uppercase fw-bold">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </form>
                <!-- mo ta sp -->
                <div class="mt-4 p-3 bg-light rounded">
                    <p class="fw-bold mb-2"><i class="fas fa-info-circle me-2"></i>Mô tả sản phẩm:</p>
                    <div class="text-muted small">
                        {!! $product->mota ?? 'Đang cập nhật nội dung mô tả...' !!}
                    </div>
                </div>
            </div>

            <div class="product-variants mt-4">
                <h5>Tùy chọn sản phẩm:</h5>
                <ul class="list-group">
                    @foreach ($product->variants as $variant)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <strong>Mã:</strong> {{ $variant->sku }}
                                @if ($variant->giaban)
                                    - <strong>Giá riêng:</strong> {{ number_format($variant->giaban, 0, ',', '.') }}đ
                                @endif
                            </span>

                            <span class="badge {{ $variant->soluong > 0 ? 'bg-primary' : 'bg-secondary' }}">
                                Kho: {{ $variant->soluong }}
                            </span>
                        </li>

                        @if ($variant->soluong > 0)
                            <span class="badge bg-success">{{ $status }}</span>
                        @else
                            <span class="badge bg-danger">Hết hàng</span>
                        @endif

                        <div class="mb-2">
                            <span class="badge {{ $product->soluong > 0 ? 'bg-success' : 'bg-danger' }}">
                                Tình trạng: {{ $status }}
                            </span>
                        </div>

                        <hr>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        .main-image {
            width: 100%;
            height: 600px;
            object-fit: cover;
        }

        .img-thumbnail:hover {
            border-color: #000;
        }
    </style>

    <script>
        function changeQty(val) {
            let qty = document.getElementById('quantity');
            let current = parseInt(qty.value);
            if (current + val >= 1) qty.value = current + val;
        }

        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }
        document.addEventListener('DOMContentLoaded', function() {
            const variantButtons = document.querySelectorAll('.variant-select');
            const skuDisplay = document.getElementById('display-sku');
            const priceDisplay = document.getElementById('display-price');

            variantButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // 1. Loại bỏ màu "đang chọn" ở các nút khác và thêm vào nút vừa bấm
                    variantButtons.forEach(btn => btn.classList.remove('btn-dark', 'text-white'));
                    this.classList.add('btn-dark', 'text-white');

                    // 2. Lấy dữ liệu từ thuộc tính data-
                    const selectedSku = this.getAttribute('data-sku');
                    const selectedPrice = this.getAttribute('data-price');
                    const stock = parseInt(this.getAttribute('data-stock'));

                    // 3. Cập nhật SKU và Giá trực tiếp lên màn hình
                    skuDisplay.innerText = selectedSku;
                    priceDisplay.innerText = selectedPrice;

                    // 4. (Tùy chọn) Thông báo nếu hết hàng
                    if (stock <= 0) {
                        skuDisplay.innerHTML += ' <span class="text-danger">(Hết hàng)</span>';
                    }
                });
            });
            // Tự động kích hoạt bấm vào nút đầu tiên khi vừa tải trang
            if (variantButtons.length > 0) variantButtons[0].click();
        });
    </script>
@endsection
