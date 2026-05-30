@extends('client.layouts')
@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Hero Carousel --}}
        @if (isset($slide) && $slide->count() > 0)
            <div class="mb-12">
                <div class="relative bg-white rounded-lg shadow-lg overflow-hidden" style="max-width: 900px; margin: 0 auto;">
                    {{-- Carousel container --}}
                    <div class="relative" style="height: 400px;">
                        @foreach ($slide as $index => $item)
                            <a href="{{ $item->linklienket }}" class="carousel-slide absolute inset-0 transition-opacity duration-500" data-slide="{{ $index }}" style="opacity: {{ $index == 0 ? '1' : '0' }}; pointer-events: {{ $index == 0 ? 'auto' : 'none' }};">
                                <img
                                    src="{{ $item->hinhthunho }}"
                                    class="w-full h-full object-cover"
                                    alt="{{ $item->tieude }}"
                                >
                                <div class="hidden md:flex absolute inset-0 bg-gradient-to-t from-black/60 to-transparent items-end p-8">
                                    <div class="text-white">
                                        <h3 class="text-3xl font-bold mb-2">{{ $item->tieude }}</h3>
                                        <p class="text-lg">{{ $item->mota }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Navigation buttons --}}
                    <button onclick="prevSlide()" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-gray-900 p-2 transition">
                        <i class="fa fa-chevron-left text-xl"></i>
                    </button>
                    <button onclick="nextSlide()" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-gray-900 p-2 transition">
                        <i class="fa fa-chevron-right text-xl"></i>
                    </button>

                    {{-- Indicators --}}
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                        @foreach ($slide as $index => $item)
                            <button
                                onclick="goToSlide({{ $index }})"
                                class="w-3 h-3 rounded-full transition {{ $index == 0 ? 'bg-white' : 'bg-white/60' }}"
                            ></button>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                let currentSlide = 0;
                const slides = @json($slide);
                const totalSlides = slides.length;

                function showSlide(n) {
                    if (n >= totalSlides) currentSlide = 0;
                    if (n < 0) currentSlide = totalSlides - 1;

                    document.querySelectorAll('.carousel-slide').forEach((el, idx) => {
                        el.style.opacity = idx === currentSlide ? '1' : '0';
                        el.style.pointerEvents = idx === currentSlide ? 'auto' : 'none';
                    });

                    document.querySelectorAll('.absolute.bottom-4 button').forEach((el, idx) => {
                        el.className = `w-3 h-3 rounded-full transition ${idx === currentSlide ? 'bg-white' : 'bg-white/60'}`;
                    });
                }

                function prevSlide() {
                    currentSlide--;
                    showSlide(currentSlide);
                }

                function nextSlide() {
                    currentSlide++;
                    showSlide(currentSlide);
                }

                function goToSlide(n) {
                    currentSlide = n;
                    showSlide(currentSlide);
                }

                setInterval(nextSlide, 5000);
            </script>
        @endif

        {{-- New Products Section --}}
        @if (isset($sanphamMoi) && $sanphamMoi->count() > 0)
            <div class="mb-16">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">New Products</h2>
                    <a href="{{ route('client.products.new') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2">
                        View All <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                    @foreach ($sanphamMoi as $sp)
                        @include('client.components.product-card', ['product' => $sp])
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Category Sections --}}
        @if (isset($danhMucNoiBat) && $danhMucNoiBat->count() > 0)
            @foreach ($danhMucNoiBat as $category)
                @if ($category->sanphams && $category->sanphams->count() > 0)
                    <div class="mb-16">
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h2>
                            <a href="{{ route('client.category.show', $category->slug) }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2">
                                View All <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                            @foreach ($category->sanphams->take(10) as $sp)
                                @include('client.components.product-card', ['product' => $sp])
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

{{-- All Products Section --}}
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shop</h1>

        {{-- Sort & Filter Bar --}}
        <div class="bg-gray-50 p-4 rounded-lg mb-6 flex justify-between items-center">
            <p class="text-sm text-gray-600">
                Showing <span class="font-semibold">{{ $sanpham->count() }}</span> products
            </p>
            <form method="GET" action="{{ route('client.products.index') }}" class="inline">
                <select
                    name="sort"
                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onchange="this.form.submit()"
                >
                    <option value="">Default Sorting</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                </select>
            </form>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
            @forelse($sanpham as $sp)
                @include('client.components.product-card', ['product' => $sp])
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No products available</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($sanpham->count() > 0)
            <div class="flex justify-center mt-8">
                {{ $sanpham->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .pagination {
        @apply flex gap-1 justify-center;
    }

    .pagination a,
    .pagination span {
        @apply px-3 py-2 rounded border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-100 transition;
    }

    .pagination .active span {
        @apply bg-blue-600 text-white border-blue-600;
    }

    .pagination .disabled span {
        @apply opacity-50 cursor-not-allowed;
    }
</style>
@endsection
