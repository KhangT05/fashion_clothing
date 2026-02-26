{{-- resources/views/client/partials/product-card.blade.php --}}
@php
    $giaGoc = $product->giaban ?? 0;
    $discount = $product->discount ?? 0;
    $giaSauGiam = $giaGoc - ($giaGoc * $discount) / 100;

    $hinhAnh = $product->hinhnen ?? asset('client/img/product-default.jpg');
    $tenSP = $product->tensp ?? 'Sản phẩm';
    $productUrl = route('client.products.show', $product->slug);

    $tonKho = 0;
    if ($product->has_attribute && $product->sanpham_variants) {
        $tonKho = $product->sanpham_variants->sum('soluong');
    }

    if ($product->has_attribute && $tonKho > 0) {
        $product->load('sanpham_variants.attributesValues.bienthe');
    }
@endphp

<div class="col">
    <div class="product-card">

        {{-- IMAGE SECTION --}}
        <div class="product-image-wrapper">
            <a href="{{ $productUrl }}" class="product-image-link">
                <img src="{{ $hinhAnh }}" class="product-image" alt="{{ $tenSP }}">
            </a>

            {{-- DISCOUNT BADGE --}}
            @if ($discount > 0)
                <div class="discount-badge">
                    -{{ (int) $discount }}%
                </div>
            @endif

            {{-- STOCK STATUS --}}
            <div class="stock-badge {{ $tonKho > 0 ? 'in-stock' : 'out-stock' }}">
                {{ $tonKho > 0 ? 'Còn hàng' : 'Hết hàng' }}
            </div>

            {{-- QUICK ADD OVERLAY --}}
            @if ($tonKho > 0)
                <div class="attribute-popover-hover" id="popover{{ $product->id }}">
                    <div class="popover-content">
                        @php
                            // GROUP ATTRIBUTES BY TYPE ID (FIX CHUẨN)
                            $attrsByType = [];
                            foreach ($product->sanpham_variants as $variant) {
                                foreach ($variant->attributesValues as $av) {
                                    $attrsByType[$av->bienthe_id][$av->id] = $av;
                                }
                            }
                        @endphp

                        @foreach ($attrsByType as $bientheId => $values)
                            <div class="attr-group">
                                <label class="attr-label">
                                    {{ $values[array_key_first($values)]->bienthe->type }}
                                </label>

                                <div class="attr-buttons">
                                    @foreach ($values as $attr)
                                        <button type="button" class="attr-btn-hover"
                                            data-attr-type="attr_{{ $bientheId }}"
                                            data-attr-id="{{ $attr->id }}">
                                            {{ $attr->value }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div id="popoverError{{ $product->id }}" class="error-message d-none">
                            <i class="fa fa-exclamation-circle"></i> Vui lòng chọn đủ tuỳ chọn
                        </div>

                        <button class="btn-add-cart" onclick="quickAddToCartHover('{{ $product->id }}')">
                            <i class="fa fa-shopping-cart"></i>
                            <span>Thêm vào giỏ</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        {{-- PRODUCT INFO SECTION --}}
        <div class="product-info">
            <a href="{{ $productUrl }}" class="product-name">
                {{ $tenSP }}
            </a>

            <div class="product-prices">
                @if ($discount > 0)
                    <span class="price-original">{{ number_format($giaGoc, 0, ',', '.') }}đ</span>
                @endif
                <span class="price-current">{{ number_format($giaSauGiam, 0, ',', '.') }}đ</span>
            </div>
        </div>
    </div>
</div>

<script>
    window.productVariantMapByAttrs{{ $product->id }} = {
        @foreach ($product->sanpham_variants as $variant)
            @php
                $pairs = [];
                foreach ($variant->attributesValues as $av) {
                    $pairs[] = 'attr_' . $av->bienthe_id . ':' . $av->id;
                }
                sort($pairs);
                $key = implode('|', $pairs);
            @endphp
                "{{ $key }}": "{{ $variant->sku }}",
        @endforeach
    };
    document.addEventListener('click', function(e) {
        if (!e.target.classList.contains('attr-btn-hover')) return;

        const type = e.target.dataset.attrType;
        const popover = e.target.closest('.attribute-popover-hover');

        popover.querySelectorAll(`[data-attr-type="${type}"]`)
            .forEach(b => b.classList.remove('active'));

        e.target.classList.add('active');
    });

    function quickAddToCartHover(productId) {
        const popover = document.getElementById('popover' + productId);
        const errorMsg = document.getElementById('popoverError' + productId);
        const variantMap = window['productVariantMapByAttrs' + productId];

        const selected = {};
        popover.querySelectorAll('.attr-btn-hover.active').forEach(btn => {
            selected[btn.dataset.attrType] = btn.dataset.attrId;
        });

        const requiredTypes = Object.keys(variantMap)[0]
            .split('|')
            .map(p => p.split(':')[0]);

        if (Object.keys(selected).length !== requiredTypes.length) {
            errorMsg.classList.remove('d-none');
            return;
        }

        const key = Object.entries(selected)
            .map(([t, v]) => `${t}:${v}`)
            .sort()
            .join('|');

        const sku = variantMap[key];
        if (!sku) {
            errorMsg.classList.remove('d-none');
            return;
        }

        errorMsg.classList.add('d-none');

        fetch('/gio-hang/add-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    sku: sku,
                    soluong: 1
                })
            })
            .then(r => r.json())
            .then(d => alert(d.message || 'Đã thêm vào giỏ'));
    }
</script>

<style>
    .product-card {
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border-color: #f0f0f0;
        transform: translateY(-4px);
    }

    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        background: #f8f8f8;
        height: 200px;
    }

    .product-image-link {
        display: block;
        width: 100%;
        height: 100%;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-image-wrapper:hover .product-image {
        transform: scale(1.08);
    }

    /* BADGES */
    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        color: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        z-index: 2;
    }

    .stock-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        z-index: 2;
    }

    .stock-badge.in-stock {
        background: rgba(76, 175, 80, 0.95);
        color: #fff;
    }

    .stock-badge.out-stock {
        background: rgba(244, 67, 54, 0.95);
        color: #fff;
    }

    /* QUICK ADD POPOVER */
    .product-image-wrapper:hover .attribute-popover-hover {
        opacity: 1;
        pointer-events: auto;
    }

    .attribute-popover-hover {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.8));
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 10;
        backdrop-filter: blur(4px);
    }

    .popover-content {
        padding: 10px;
        color: #fff;
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 140px;
        overflow-y: auto;
    }

    .popover-content::-webkit-scrollbar {
        width: 4px;
    }

    .popover-content::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
    }

    .popover-content::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }

    .popover-content::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .attr-group {
        margin-bottom: 6px;
    }

    .attr-group:last-of-type {
        margin-bottom: 0;
    }

    .attr-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: #e0e0e0;
        margin-bottom: 4px;
        letter-spacing: 0.3px;
    }

    .attr-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }

    .attr-btn-hover {
        border: 1px solid rgba(255, 255, 255, 0.4);
        background: transparent;
        color: #fff;
        padding: 4px 8px;
        font-size: 11px;
        font-weight: 500;
        cursor: pointer;
        border-radius: 3px;
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .attr-btn-hover:hover {
        border-color: #fff;
        background: rgba(255, 255, 255, 0.15);
    }

    .attr-btn-hover.active {
        background: #ff6b6b;
        border-color: #ff6b6b;
        color: #fff;
    }

    .error-message {
        color: #ffcdd2;
        font-size: 11px;
        padding: 5px 6px;
        background: rgba(255, 0, 0, 0.15);
        border-radius: 3px;
        margin: 4px 0;
        display: flex;
        align-items: center;
        gap: 4px;
        line-height: 1.3;
    }

    .btn-add-cart {
        width: 100%;
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        color: #fff;
        border: none;
        padding: 8px 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border-radius: 3px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 0;
        flex-shrink: 0;
    }

    .btn-add-cart:hover {
        background: linear-gradient(135deg, #ff5252, #dd4463);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
    }

    /* PRODUCT INFO */
    .product-info {
        padding: 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        text-decoration: none;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }

    .product-name:hover {
        color: #ff6b6b;
    }

    .product-prices {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .price-original {
        font-size: 12px;
        color: #999;
        text-decoration: line-through;
        font-weight: 400;
    }

    .price-current {
        font-size: 15px;
        font-weight: 700;
        color: #ff6b6b;
    }

    /* RESPONSIVE */
    @media (max-width: 576px) {
        .product-image-wrapper {
            height: 180px;
        }

        .product-info {
            padding: 10px;
        }

        .product-name {
            font-size: 13px;
        }

        .price-current {
            font-size: 14px;
        }

        .popover-content {
            padding: 12px;
        }

        .discount-badge {
            top: 8px;
            right: 8px;
            font-size: 12px;
            padding: 5px 10px;
        }
    }
</style>
