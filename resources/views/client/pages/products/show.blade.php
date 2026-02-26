@extends('client.layouts')
@section('title', 'Trang chi tiết sản phẩm')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong>Thành công!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>Lỗi!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">{{ $product->tensp }}</li>
            </ol>
        </nav>
        <div class="row">
            {{-- Cột trái: Hình ảnh --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 mb-3">
                    <img src="{{ asset($product->hinhnen) }}" class="img-fluid rounded main-image" id="mainImage"
                        alt="{{ $product->tensp }}">
                </div>
                {{-- Album ảnh - FIXED --}}
                <div class="row g-2 mb-4" id="album-container">
                    <div class="col-3">
                        <img src="{{ asset($product->hinhnen) }}" class="img-thumbnail cursor-pointer thumbnail-img active"
                            onclick="changeMainImage('{{ asset($product->hinhnen) }}')"
                            style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;">
                    </div>
                    @if ($defaultVariant && $defaultVariant->album)
                        @foreach ($defaultVariant->album as $img)
                            <div class="col-3">
                                <img src="{{ asset($img) }}" class="img-thumbnail cursor-pointer thumbnail-img"
                                    onclick="changeMainImage('{{ asset($img) }}')"
                                    style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;">
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- Phần bình luận --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Đánh giá sản phẩm ({{ $ratingCount }})</h5>
                    </div>
                    <div class="card-body">
                        @if ($product->binhluan->where('trangthai', 1)->count() > 0)
                            <div id="comment-container">
                                @foreach ($product->binhluan->where('trangthai', 1) as $index => $bl)
                                    <div class="comment {{ $index >= 3 ? 'd-none hidden-comment' : '' }}"
                                        style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding: 10px 0;">
                                        <div class="d-flex align-items-center mb-2">
                                            <strong>{{ $bl->user->name }}</strong>
                                            <span class="ms-auto text-warning">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $bl->danhgia)
                                                        ⭐
                                                    @else
                                                        <span style="color: #ddd;">⭐</span>
                                                    @endif
                                                @endfor
                                            </span>
                                        </div>
                                        <p class="mb-1">{{ $bl->noidung }}</p>
                                        <small class="text-muted">{{ $bl->created_at->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                            </div>

                            @if ($product->binhluan->where('trangthai', 1)->count() > 3)
                                <button id="toggleCommentBtn" class="btn btn-link p-0" data-status="closed">
                                    Xem thêm đánh giá...
                                </button>
                            @endif
                        @else
                            <p class="text-muted text-center">Chưa có đánh giá nào</p>
                        @endif
                    </div>
                </div>

                {{-- Form đánh giá --}}
                @auth
                    @if ($hasPurchased)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                {{-- <h6 class="fw-bold mb-3">Để lại đánh giá của bạn</h6>
                                <form action="{{ route('client.products.comment', $product->slug) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <div class="star-rating">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="write-star{{ $i }}" name="danhgia"
                                                    value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} />
                                                <label for="write-star{{ $i }}">
                                                    <span style="font-size: 24px; cursor:pointer;">⭐</span>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" name="noidung" class="form-control"
                                            placeholder="Viết đánh giá của bạn..." required maxlength="500">
                                        <button class="btn btn-primary" type="submit">Gửi</button>
                                    </div>
                                </form> --}}
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Bạn cần mua và nhận sản phẩm này để có thể đánh giá
                        </div>
                    @endif
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle"></i> Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để đánh
                        giá sản phẩm
                    </div>
                @endauth
            </div>

            {{-- Cột phải: Thông tin sản phẩm --}}
            <div class="col-md-6">
                <h1 class="h2 fw-bold">{{ $product->tensp }}</h1>

                {{-- Thống kê --}}
                <div class="d-flex gap-3 mb-3 text-muted small">
                    <span>
                        <i class="fa-regular fa-eye me-1"></i>
                        <strong>{{ number_format($product->view) }}</strong> lượt xem
                    </span>
                    <span>
                        <i class="fa-regular fa-heart me-1"></i>
                        <strong id="wishlist-count">{{ number_format($wishlistCount) }}</strong> yêu thích
                    </span>
                    <span>
                        <i class="fa-regular fa-star me-1"></i>
                        <strong>{{ $averageRating }}</strong>/5 ({{ $ratingCount }} đánh giá)
                    </span>
                </div>

                {{-- Đánh giá trung bình --}}
                <div class="mb-3">
                    @if ($averageRating > 0)
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-warning fs-5">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($averageRating))
                                        ⭐
                                    @elseif ($i - $averageRating < 1)
                                        <span style="position:relative; display:inline-block;">
                                            <span style="color: #ddd;">⭐</span>
                                            <span
                                                style="position:absolute; left:0; overflow:hidden; width:{{ ($averageRating - floor($averageRating)) * 100 }}%;">⭐</span>
                                        </span>
                                    @else
                                        <span style="color: #ddd;">⭐</span>
                                    @endif
                                @endfor
                            </div>
                            <strong>{{ $averageRating }}</strong>
                        </div>
                    @endif
                </div>

                {{-- Giá và SKU --}}
                <div class="product-info mt-3">
                    <div class="mb-3">
                        <strong id="display-sku" class="small text-muted d-block mb-1">
                            SKU: {{ $defaultVariant->sku ?? 'N/A' }}
                        </strong>

                        <h2 id="display-price" class="text-danger fw-bold mb-2">
                            {{ number_format($defaultVariant->giaban ?? 0, 0, ',', '.') }}đ
                        </h2>

                        <div class="d-flex align-items-center gap-2">
                            <span id="display-stock-count"
                                class="badge {{ ($defaultVariant->soluong ?? 0) > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ ($defaultVariant->soluong ?? 0) > 0 ? "Còn {$defaultVariant->soluong} sản phẩm" : 'Hết hàng' }}
                            </span>
                            <span class="text-muted small" id="stock-realtime-indicator">
                                <i class="fa fa-circle text-success" style="font-size: 8px;"></i> Realtime
                            </span>
                        </div>
                    </div>

                    {{-- Nút yêu thích --}}
                    @auth
                        <button type="button" class="btn-wishlist {{ $isWishlisted ? 'active' : '' }}"
                            onclick="toggleWishlist({{ $product->id }})">
                            <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                        </button>
                    @endauth
                </div>

                {{-- Chọn biến thể --}}
                @if ($groupedAttributes->count() > 0)
                    <div class="product-variants mt-4">
                        @foreach ($groupedAttributes as $typeName => $values)
                            <div class="mb-4 attribute-group" data-type="{{ $typeName }}">
                                <h6 class="text-uppercase fw-bold" style="font-size: 0.85rem;">
                                    {{ $typeName }}:
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($values as $val)
                                        <input type="radio" class="btn-check attribute-select"
                                            name="attr_{{ Str::slug($typeName) }}" id="val_{{ $val->id }}"
                                            value="{{ $val->value }}" data-value-id="{{ $val->id }}"
                                            {{ $loop->first ? 'checked' : '' }}>
                                        <label class="btn btn-outline-dark" for="val_{{ $val->id }}">
                                            {{ $val->value }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Thêm vào giỏ hàng --}}
                <div class="mt-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="input-group" style="width: 150px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)">-</button>
                            <input type="number" class="form-control text-center" value="1" id="quantity"
                                min="1" max="{{ $defaultVariant->soluong ?? 1 }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)">+</button>
                        </div>
                        @foreach ($product->sanpham_variants as $variant)
                            @php
                                $tonKhoVariant = $variant->soluong;
                            @endphp

                            @if ($tonKhoVariant > 0)
                                <button onclick="addToCart('{{ $variant->sku }}')"
                                    class="btn btn-sm rounded-circle p-1 btn-primary transition"
                                    title="Thêm vào giỏ hàng">
                                    <i class="fa fa-shopping-cart text-white" style="font-size: 11px;"></i>
                                </button>
                                @break
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Mô tả ngắn --}}
                <div class="mt-4 p-3 bg-light rounded">
                    <p class="fw-bold mb-2">
                        <i class="fas fa-info-circle me-2"></i>Mô tả sản phẩm:
                    </p>
                    <div class="text-muted small">
                        {!! Str::limit($product->mota ?? 'Đang cập nhật...', 300) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab mô tả chi tiết --}}
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button">
                            Mô tả chi tiết
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs"
                            type="button">
                            Thông số kỹ thuật
                        </button>
                    </li>
                </ul>
                <div class="tab-content p-4 border border-top-0" id="productTabContent">
                    <div class="tab-pane fade show active" id="description">
                        {!! $product->mota ?? 'Đang cập nhật nội dung...' !!}
                    </div>
                    <div class="tab-pane fade" id="specs">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">SKU</th>
                                    <td>{{ $defaultVariant->sku ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Thương hiệu</th>
                                    <td>{{ $product->thuonghieu->tenth ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td>{{ $product->categories->pluck('name')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái kho</th>
                                    <td>
                                        <span
                                            class="badge {{ $defaultVariant->soluong > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $defaultVariant->soluong > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sản phẩm liên quan --}}
        <div class="mt-5">
            <h4 class="fw-bold mb-4">Sản phẩm liên quan</h4>
            <div class="row row-cols-2 row-cols-md-5 g-3">
                @forelse ($relatedProducts as $related)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm">
                            <a href="{{ route('client.products.show', $related->slug) }}">
                                <img src="{{ asset($related->hinhnen) }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="{{ $related->tensp }}">
                            </a>
                            <div class="card-body p-3">
                                <h6 class="card-title text-truncate-2 mb-2" style="font-size: 0.9rem;">
                                    <a href="{{ route('client.products.show', $related->slug) }}"
                                        class="text-decoration-none text-dark">
                                        {{ $related->tensp }}
                                    </a>
                                </h6>
                                @php
                                    $relatedVariant = $related->sanpham_variants->first();
                                @endphp
                                <span class="text-danger fw-bold d-block mb-2">
                                    {{ number_format($relatedVariant->giaban ?? 0, 0, ',', '.') }}đ
                                </span>
                                <div class="d-flex align-items-center text-muted" style="font-size: 0.8rem;">
                                    <span class="text-warning me-2">
                                        ⭐ {{ number_format($related->binhluan_avg_danhgia ?? 0, 1) }}
                                    </span>
                                    <span>{{ number_format($related->view) }} views</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Không có sản phẩm liên quan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .main-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .thumbnail-img {
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .thumbnail-img:hover,
        .thumbnail-img.active {
            border-color: #007bff;
            transform: scale(1.05);
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            filter: grayscale(100%);
            opacity: 0.3;
            transition: 0.2s;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            filter: grayscale(0%);
            opacity: 1;
        }

        .btn-wishlist {
            background: white;
            border: 2px solid #ddd;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-wishlist i {
            font-size: 24px;
            color: #999;
            transition: all 0.3s;
        }

        .btn-wishlist.active {
            border-color: #ff4d4d !important;
            background-color: #fff0f0 !important;
        }

        .btn-wishlist.active i {
            color: #ff4d4d !important;
        }

        .btn-check:checked+.btn-outline-dark {
            background-color: #212529 !important;
            color: #fff !important;
        }

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection

@push('scripts')
    <script>
        const productVariants = @json($product->sanpham_variants->load('attributesValues'));
        let currentVariantId = {{ $defaultVariant->id ?? 'null' }}; // ✅ FIXED: Thêm let để có thể update

        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail-img').forEach(img => img.classList.remove('active'));
            event.target.classList.add('active');
        }

        function changeQty(val) {
            const qtyInput = document.getElementById('quantity');
            const max = parseInt(qtyInput.getAttribute('max')) || 999;
            let current = parseInt(qtyInput.value);
            let newQty = current + val;
            if (newQty >= 1 && newQty <= max) qtyInput.value = newQty;
        }

        // ✅ FIXED: Cập nhật album khi chọn variant
        function updateAlbumImages(variant) {
            const albumContainer = document.getElementById('album-container');
            let albumHTML = `
                <div class="col-3">
                    <img src="{{ asset($product->hinhnen) }}"
                        class="img-thumbnail cursor-pointer thumbnail-img active"
                        onclick="changeMainImage('{{ asset($product->hinhnen) }}')"
                        style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;">
                </div>
            `;

            if (variant.album && Array.isArray(variant.album)) {
                variant.album.forEach(img => {
                    albumHTML += `
                        <div class="col-3">
                            <img src="${img.startsWith('http') ? img : '/' + img}"
                                class="img-thumbnail cursor-pointer thumbnail-img"
                                onclick="changeMainImage('${img.startsWith('http') ? img : '/' + img}')"
                                style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;">
                        </div>
                    `;
                });
            }

            albumContainer.innerHTML = albumHTML;
        }

        function updateVariantInfo() {
            let selectedValueIds = [];
            document.querySelectorAll('.attribute-select:checked').forEach(input => {
                const id = input.getAttribute('data-value-id');
                if (id) selectedValueIds.push(parseInt(id));
            });

            const matchedVariant = productVariants.find(variant => {
                const vValues = variant.attributes_values || variant.attributesValues || [];
                const vIds = vValues.map(v => v.id);
                return selectedValueIds.every(id => vIds.includes(id)) && vIds.length === selectedValueIds.length;
            });

            if (matchedVariant) {
                // ✅ FIXED: Cập nhật currentVariantId
                currentVariantId = matchedVariant.id;

                document.getElementById('display-sku').innerText = 'SKU: ' + matchedVariant.sku;
                document.getElementById('display-price').innerText = new Intl.NumberFormat('vi-VN').format(matchedVariant
                    .giaban) + 'đ';

                const stockEl = document.getElementById('display-stock-count');
                const qtyInput = document.getElementById('quantity');
                const addBtn = document.getElementById('add-to-cart-btn');

                if (matchedVariant.soluong > 0) {
                    stockEl.innerText = `Còn ${matchedVariant.soluong} sản phẩm`;
                    stockEl.className = 'badge bg-success';
                    qtyInput.setAttribute('max', matchedVariant.soluong);
                    qtyInput.value = 1; // Reset quantity
                    if (addBtn) {
                        addBtn.removeAttribute('disabled');
                        addBtn.innerHTML = '<i class="fa fa-shopping-cart me-2"></i>Thêm vào giỏ hàng';
                    }
                } else {
                    stockEl.innerText = "Hết hàng";
                    stockEl.className = 'badge bg-danger';
                    qtyInput.setAttribute('max', 0);
                    qtyInput.value = 1;
                    if (addBtn) {
                        addBtn.setAttribute('disabled', 'disabled');
                        addBtn.innerHTML = '<i class="fa fa-ban me-2"></i>Hết hàng';
                    }
                }

                // ✅ FIXED: Cập nhật album ảnh
                updateAlbumImages(matchedVariant);
            }
        }

        document.querySelectorAll('.attribute-select').forEach(input => {
            input.addEventListener('change', updateVariantInfo);
        });
        updateVariantInfo();

        document.getElementById('toggleCommentBtn')?.addEventListener('click', function() {
            const hidden = document.querySelectorAll('.hidden-comment');
            const isHidden = hidden[0]?.classList.contains('d-none');
            hidden.forEach(el => el.classList.toggle('d-none'));
            this.innerText = isHidden ? 'Ẩn bớt' : 'Xem thêm đánh giá...';
        });

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

        function addToCart(sku) {
            sku = sku.trim();

            console.log('SKU gửi đi:', sku);

            fetch('/gio-hang/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        sku: sku,
                        soluong: 1
                    })
                })
                .then(res => {
                    if (res.status === 401) {
                        window.location.href = '/login';
                        return;
                    }
                    return res.json();
                })
                .then(data => {
                    if (data?.success) {
                        alert('Đã thêm vào giỏ hàng!');
                        updateCartCount(data.cart_count ?? null);
                    } else if (data?.message) {
                        alert(data.message);
                    }
                })
                .catch(err => console.error(err));
        }
        setInterval(() => {
            if (currentVariantId) {
                fetch(`/api/variant-info?variant_id=${currentVariantId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const stockEl = document.getElementById('display-stock-count');
                            const qty = data.data.soluong;
                            stockEl.innerText = qty > 0 ? `Còn ${qty} sản phẩm` : 'Hết hàng';
                            stockEl.className = qty > 0 ? 'badge bg-success' : 'badge bg-danger';
                        }
                    })
                    .catch(err => console.error('Error refreshing stock:', err));
            }
        }, 30000);
    </script>
@endpush
