<div class="relative cart-widget">
    <a href="{{ route('carts.index') }}" class="flex items-center gap-2 hover:text-blue-600 transition">
        <div class="relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            @if (Auth::check())
                <span
                    class="cart-badge absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold"
                    data-cart-badge>
                    0
                </span>
            @endif
        </div>

        @if (Auth::check())
            <div class="hidden md:flex flex-col items-start">
                <span class="text-xs text-gray-500">Giỏ hàng</span>
                <span data-cart-badge class="font-semibold">0</span>
            </div>
        @endif
    </a>

    <!-- Mini Cart Dropdown -->
    <div
        class="cart-dropdown hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-2xl z-50 border border-gray-200">
        <div class="p-4">
            <h3 class="font-semibold mb-4 text-gray-800">Giỏ hàng của bạn</h3>

            <div class="border-t pt-4 space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">Tổng số lượng</span>
                    <span class="font-semibold text-red-500" data-cart-badge>0</span>
                </div>

                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">Tổng tiền</span>
                    <span class="font-bold text-red-600" data-cart-total>0 ₫</span>
                </div>

                <a href="{{ route('carts.index') }}"
                    class="block w-full bg-blue-600 text-white text-center py-2.5 rounded-lg hover:bg-blue-700 transition font-medium">
                    Xem giỏ hàng
                </a>
            </div>
        </div>
    </div>
</div>
