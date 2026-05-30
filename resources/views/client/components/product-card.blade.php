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

<div class="w-full">
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg hover:border-gray-300 transition-all duration-300 flex flex-col h-full group">

        {{-- IMAGE SECTION --}}
        <div class="relative overflow-hidden bg-gray-100 h-48 md:h-56">
            <a href="{{ $productUrl }}" class="block w-full h-full">
                <img
                    src="{{ $hinhAnh }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    alt="{{ $tenSP }}"
                    loading="lazy"
                >
            </a>

            {{-- DISCOUNT BADGE --}}
            @if ($discount > 0)
                <div class="absolute top-3 right-3 bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1 rounded-md font-semibold text-sm shadow-md">
                    -{{ (int) $discount }}%
                </div>
            @endif

            {{-- STOCK STATUS --}}
            <div class="absolute bottom-3 left-3 px-3 py-1 rounded-full text-xs font-semibold text-white {{ $tonKho > 0 ? 'bg-green-500' : 'bg-red-500' }}">
                {{ $tonKho > 0 ? 'In Stock' : 'Out of Stock' }}
            </div>

            {{-- QUICK ADD OVERLAY --}}
            @if ($tonKho > 0)
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3 gap-3" id="popover{{ $product->id }}">
                    <div class="space-y-2">
                        @php
                            $attrsByType = [];
                            foreach ($product->sanpham_variants as $variant) {
                                foreach ($variant->attributesValues as $av) {
                                    $attrsByType[$av->bienthe_id][$av->id] = $av;
                                }
                            }
                        @endphp

                        @foreach ($attrsByType as $bientheId => $values)
                            <div class="attr-group">
                                <label class="text-xs font-bold text-gray-300 uppercase tracking-wide block mb-1">
                                    {{ $values[array_key_first($values)]->bienthe->type }}
                                </label>

                                <div class="flex flex-wrap gap-1">
                                    @foreach ($values as $attr)
                                        <button
                                            type="button"
                                            class="attr-btn-hover px-2 py-1 rounded text-xs font-medium border border-white/40 text-white hover:bg-white/15 hover:border-white transition-all duration-200"
                                            data-attr-type="attr_{{ $bientheId }}"
                                            data-attr-id="{{ $attr->id }}">
                                            {{ $attr->value }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div id="popoverError{{ $product->id }}" class="hidden text-red-200 text-xs px-2 py-1 bg-red-500/20 rounded flex items-center gap-1">
                            <i class="fa fa-exclamation-circle"></i>
                            <span>Please select all options</span>
                        </div>
                    </div>

                    <button
                        class="btn-add-cart w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2 rounded transition-all duration-200 flex items-center justify-center gap-2 transform hover:-translate-y-1"
                        onclick="quickAddToCartHover('{{ $product->id }}')">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Add to Cart</span>
                    </button>
                </div>
            @endif
        </div>

        {{-- PRODUCT INFO SECTION --}}
        <div class="p-3 md:p-4 flex flex-col flex-1">
            <a href="{{ $productUrl }}" class="text-sm md:text-base font-semibold text-gray-900 hover:text-red-500 transition-colors line-clamp-2 mb-2">
                {{ $tenSP }}
            </a>

            <div class="flex items-center gap-2 flex-wrap mt-auto pt-2">
                @if ($discount > 0)
                    <span class="text-xs md:text-sm text-gray-400 line-through">{{ number_format($giaGoc, 0, ',', '.') }}đ</span>
                @endif
                <span class="text-base md:text-lg font-bold text-red-500">{{ number_format($giaSauGiam, 0, ',', '.') }}đ</span>
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
                "{{ $key }}": {
                    "sku": "{{ $variant->sku }}",
                    "id": "{{ $variant->id }}"
                },
        @endforeach
    };

    document.addEventListener('click', function(e) {
        if (!e.target.classList.contains('attr-btn-hover')) return;

        const type = e.target.dataset.attrType;
        const popover = e.target.closest('[id^="popover"]');

        popover.querySelectorAll(`[data-attr-type="${type}"]`)
            .forEach(b => {
                b.classList.remove('bg-red-500', 'border-red-500');
                b.classList.add('border-white/40', 'hover:bg-white/15');
            });

        e.target.classList.add('bg-red-500', 'border-red-500');
        e.target.classList.remove('border-white/40', 'hover:bg-white/15');
    });

    function quickAddToCartHover(productId) {
        const popover = document.getElementById('popover' + productId);
        const errorMsg = document.getElementById('popoverError' + productId);
        const variantMap = window['productVariantMapByAttrs' + productId];

        const selected = {};
        popover.querySelectorAll('.attr-btn-hover.bg-red-500').forEach(btn => {
            selected[btn.dataset.attrType] = btn.dataset.attrId;
        });

        const requiredTypes = Object.keys(variantMap)[0]
            .split('|')
            .map(p => p.split(':')[0]);

        if (Object.keys(selected).length !== requiredTypes.length) {
            errorMsg?.classList.remove('hidden');
            return;
        }

        const key = Object.entries(selected)
            .map(([t, v]) => `${t}:${v}`)
            .sort()
            .join('|');

        const variantData = variantMap[key];
        if (!variantData) {
            errorMsg?.classList.remove('hidden');
            return;
        }

        errorMsg?.classList.add('hidden');

        fetch('/gio-hang/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                sku: variantData.sku,
                soluong: 1
            })
        })
        .then(r => r.json())
        .then(d => {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: d.message || 'Added to cart'
            });
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to add to cart'
            });
        });
    }
</script>
