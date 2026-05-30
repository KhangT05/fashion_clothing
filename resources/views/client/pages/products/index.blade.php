@extends('client.layouts')
@section('title', 'Shop')
@section('content')
<div class="bg-gray-50 py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Shop</h1>
            <p class="text-gray-600 mt-2">Discover our complete collection of products</p>
        </div>

        {{-- Filter Section --}}
        @include('client.pages.products.components.shop-filter')

        {{-- Products Grid --}}
        <div class="space-y-8">
            {{-- Products Container --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                @forelse($product as $sp)
                    @include('client.components.product-card', ['product' => $sp])
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="inline-block">
                            <i class="fa fa-inbox text-5xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg mt-4">No products found</p>
                            <p class="text-gray-400 text-sm mt-2">Try adjusting your search or filter criteria</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($product->count() > 0)
                <div class="flex justify-center mt-8">
                    <div class="inline-flex gap-2">
                        {{ $product->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Tailwind pagination override for Bootstrap */
    .pagination {
        @apply flex gap-1;
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
