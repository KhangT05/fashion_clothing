@extends('client.layouts')
@section('content')
<div class="bg-gray-50 py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex text-sm mb-6" aria-label="Breadcrumb">
            <ol class="flex gap-2">
                <li><a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Home</a></li>
                <li class="text-gray-500">/</li>
                <li class="text-gray-900 font-medium">{{ $product->tensp }}</li>
            </ol>
        </nav>

        {{-- Main Product Section --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- Image Gallery --}}
                <div class="space-y-4">
                    <div class="bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                        <img
                            src="{{ asset('client/img/' . basename($product->hinhnen)) }}"
                            class="w-full h-80 md:h-96 object-cover main-image"
                            id="mainImage"
                            alt="{{ $product->tensp }}"
                        >
                    </div>

                    {{-- Album Thumbnails --}}
                    @if (!empty($albumImages) && count($albumImages) > 0)
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($albumImages as $image)
                                <button
                                    type="button"
                                    onclick="changeImage('{{ $image }}')"
                                    class="w-20 h-20 rounded border-2 border-gray-200 hover:border-blue-500 overflow-hidden transition"
                                >
                                    <img src="{{ $image }}" class="w-full h-full object-cover" alt="Product image">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="space-y-6">
                    {{-- Title & Rating --}}
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">{{ $product->tensp }}</h1>

                        @if ($ratingCount > 0)
                            <div class="flex items-center gap-2">
                                <div class="flex gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600">{{ $averageRating }}/5 ({{ $ratingCount }} reviews)</span>
                            </div>
                        @endif
                    </div>

                    {{-- Pricing --}}
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 p-6 rounded-2xl border-2 border-indigo-200 dark:border-indigo-700/50">
                        <p class="text-slate-600 dark:text-slate-400 text-sm font-semibold mb-3 uppercase tracking-wide">Price</p>
                        <div class="flex items-end gap-4">
                            <span class="text-4xl md:text-5xl font-black text-red-600 dark:text-red-400" id="display-price">
                                {{ number_format($defaultVariant->giaban ?? $product->giaban, 0, ',', '.') }}đ
                            </span>
                            @if ($product->discount > 0)
                                <div class="flex flex-col gap-2 ml-auto">
                                    <span class="text-xl text-slate-400 dark:text-slate-500 line-through">
                                        {{ number_format($defaultVariant->giaban ?? $product->giaban, 0, ',', '.') }}đ
                                    </span>
                                    <span class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-1 rounded-lg text-sm font-bold shadow-lg">
                                        SAVE {{ $product->discount }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- SKU & Stock Info --}}
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="bg-gray-50 p-3 rounded border border-gray-200">
                            <p class="text-gray-600 mb-1">SKU</p>
                            <p class="font-semibold text-gray-900" id="display-sku">
                                {{ $defaultVariant->sku ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border border-gray-200">
                            <p class="text-gray-600 mb-1">Stock Available</p>
                            <p class="font-semibold" id="display-stock-count">
                                <span class="text-green-600">{{ $tonKho ?? $product->sanpham_variants->sum('soluong') }}</span> units
                            </p>
                        </div>
                    </div>

                    {{-- Variants --}}
                    @if ($product->has_attribute && count($groupedAttributes) > 0)
                        <div class="space-y-4 border-t border-b py-4">
                            @foreach ($groupedAttributes as $attrName => $attrValues)
                                <div>
                                    <label class="text-sm font-semibold text-gray-900 mb-3 block">
                                        Choose {{ $attrName ?? 'Option' }}
                                    </label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($attrValues as $value)
                                            <button
                                                type="button"
                                                class="variant-select px-4 py-2 rounded border-2 border-gray-300 hover:border-blue-500 font-medium text-sm transition-all"
                                                data-variant-id="{{ $value->id }}"
                                                data-price="{{ $value->giaban ?? 0 }}"
                                            >
                                                {{ $value->value ?? 'N/A' }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Quantity & Add to Cart --}}
                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center gap-3">
                            <label class="text-sm font-semibold text-gray-900">Quantity</label>
                            <div class="inline-flex border border-gray-300 rounded-lg">
                                <button type="button" onclick="changeQty(-1)" class="px-4 py-2 text-gray-600 hover:bg-gray-100">−</button>
                                <input type="text" class="w-16 text-center font-semibold border-l border-r border-gray-300" value="1" id="quantity" name="quantity" readonly>
                                <button type="button" onclick="changeQty(1)" class="px-4 py-2 text-gray-600 hover:bg-gray-100">+</button>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 dark:from-indigo-500 dark:to-indigo-600 dark:hover:from-indigo-600 dark:hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 transform hover:shadow-2xl hover:scale-105 shadow-xl"
                        >
                            <i class="fa fa-shopping-cart text-xl"></i>
                            <span class="text-lg">Add to Cart</span>
                        </button>
                    </form>

                    {{-- Wishlist --}}
                    <button
                        onclick="toggleWishlist({{ $product->id }})"
                        class="w-full border-2 border-slate-300 dark:border-slate-600 hover:border-red-500 dark:hover:border-red-500 text-slate-900 dark:text-slate-100 hover:text-red-500 dark:hover:text-red-400 font-bold py-3 px-4 rounded-xl transition-all duration-300 hover:bg-red-50 dark:hover:bg-red-900/10 shadow-sm"
                        id="wishlist-btn"
                    >
                        <i class="fa fa-heart{{ $isWishlisted ? '' : '-o' }}"></i>
                        <span id="wishlist-text" class="ml-2">{{ $isWishlisted ? '❤️ Remove from Wishlist' : '🤍 Add to Wishlist' }}</span>
                    </button>

                    {{-- Additional Info --}}
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-700/50 rounded-2xl p-5 text-sm space-y-3">
                        <p class="font-bold text-slate-900 dark:text-slate-100 flex items-center gap-3">
                            <span class="text-xl">✓</span>
                            <span>Free & Fast Shipping</span>
                        </p>
                        <p class="font-bold text-slate-900 dark:text-slate-100 flex items-center gap-3">
                            <span class="text-xl">✓</span>
                            <span>100% Authentic Guarantee</span>
                        </p>
                        <p class="font-bold text-slate-900 dark:text-slate-100 flex items-center gap-3">
                            <span class="text-xl">✓</span>
                            <span>Easy 30-Day Returns</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description Section --}}
        <div class="mt-12 bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8 md:p-12">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center gap-3">
                <span class="w-1 h-8 bg-indigo-600 rounded"></span>
                Product Description
            </h2>
            <div class="prose prose-sm dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed">
                {!! $product->mota ?? '<p class="text-slate-400 italic">Description coming soon...</p>' !!}
            </div>
        </div>

        {{-- Variants Details Table --}}
        @if (count($product->sanpham_variants) > 0)
            <div class="mt-12 bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8 md:p-12 overflow-hidden">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-8 flex items-center gap-3">
                    <span class="w-1 h-8 bg-indigo-600 rounded"></span>
                    Available Variants
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-slate-100 to-slate-50 dark:from-slate-700 dark:to-slate-600 border-b-2 border-slate-300 dark:border-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-slate-900 dark:text-slate-100">SKU</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-900 dark:text-slate-100">Price</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-900 dark:text-slate-100">Stock</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-900 dark:text-slate-100">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach ($product->sanpham_variants as $variant)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-slate-900 dark:text-slate-100 font-semibold">{{ $variant->sku }}</td>
                                    <td class="px-6 py-4 font-bold text-red-600 dark:text-red-400 text-lg">
                                        {{ number_format($variant->giaban ?? $product->giaban, 0, ',', '.') }}đ
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1.5 rounded-full text-xs font-bold {{ $variant->soluong > 0 ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' }}">
                                            {{ $variant->soluong }} units
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($variant->soluong > 0)
                                            <span class="inline-flex items-center gap-2 text-green-600 dark:text-green-400 font-semibold">
                                                <i class="fa fa-check-circle text-lg"></i> In Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 text-red-600 dark:text-red-400 font-semibold">
                                                <i class="fa fa-times-circle text-lg"></i> Out of Stock
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Related Products --}}
        @if (count($relatedProducts) > 0)
            <div class="mt-12">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-8 flex items-center gap-3">
                    <span class="w-1 h-8 bg-indigo-600 rounded"></span>
                    Related Products
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        @include('client.components.product-card', ['product' => $related])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    let selectedVariants = {};

    function changeQty(val) {
        let qty = document.getElementById('quantity');
        let current = parseInt(qty.value);
        if (current + val >= 1) qty.value = current + val;
    }

    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    function toggleWishlist(productId) {
        fetch(`/products/${productId}/toggle-wishlist`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const btn = document.getElementById('wishlist-btn');
                const text = document.getElementById('wishlist-text');
                if (data.action === 'added') {
                    btn.classList.add('text-red-500', 'border-red-500');
                    text.textContent = 'Remove from Wishlist';
                    text.innerHTML = '<i class="fa fa-heart"></i> ' + text.textContent;
                } else {
                    btn.classList.remove('text-red-500', 'border-red-500');
                    text.textContent = 'Add to Wishlist';
                    text.innerHTML = '<i class="fa fa-heart-o"></i> ' + text.textContent;
                }
                Swal.fire('Success', data.message, 'success');
            }
        })
        .catch(err => Swal.fire('Error', 'Failed to update wishlist', 'error'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const variantButtons = document.querySelectorAll('.variant-select');
        const priceDisplay = document.getElementById('display-price');
        const skuDisplay = document.getElementById('display-sku');
        const stockDisplay = document.getElementById('display-stock-count');

        variantButtons.forEach(button => {
            button.addEventListener('click', function() {
                const parentDiv = this.closest('div');
                parentDiv.querySelectorAll('.variant-select').forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                    btn.classList.add('border-gray-300');
                });

                this.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                this.classList.remove('border-gray-300');

                const variantId = this.dataset.variantId;
                const price = this.dataset.price;

                fetch(`/products/variant-info`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ variant_id: variantId })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        priceDisplay.textContent = data.data.gia_sau_giam_formatted + 'đ';
                        skuDisplay.textContent = data.data.sku;
                        stockDisplay.innerHTML = `<span class="${data.data.soluong > 0 ? 'text-green-600' : 'text-red-600'}">${data.data.soluong}</span> units`;
                    }
                });
            });
        });

        if (variantButtons.length > 0) {
            variantButtons[0].click();
        }
    });
</script>
@endsection
