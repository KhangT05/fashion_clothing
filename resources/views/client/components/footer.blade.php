<footer class="bg-gray-900 text-gray-300 py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 mb-8">
            {{-- About Section --}}
            <div>
                <h3 class="text-white font-bold text-lg mb-4">{{ $setting->name ?? 'eShop' }}</h3>
                <p class="text-sm mb-2">{{ $setting->phone ?? '+1 234 567 890' }}</p>
                <p class="text-sm mb-2">{{ $setting->email ?? 'info@eshop.com' }}</p>
                <p class="text-sm mb-4">{{ $setting->description ?? 'Your trusted online shopping destination' }}</p>
                <div class="flex gap-4">
                    @if ($setting->facebook_url ?? null)
                        <a href="{{ $setting->facebook_url }}" target="_blank" class="text-gray-400 hover:text-blue-500 transition">
                            <i class="fa-brands fa-facebook text-xl"></i>
                        </a>
                    @endif
                    @if ($setting->youtube_url ?? null)
                        <a href="{{ $setting->youtube_url }}" target="_blank" class="text-gray-400 hover:text-red-500 transition">
                            <i class="fa-brands fa-youtube text-xl"></i>
                        </a>
                    @endif
                    @if ($setting->instagram_url ?? null)
                        <a href="{{ $setting->instagram_url }}" target="_blank" class="text-gray-400 hover:text-pink-500 transition">
                            <i class="fa-brands fa-instagram text-xl"></i>
                        </a>
                    @endif
                    @if ($setting->linkedin_url ?? null)
                        <a href="{{ $setting->linkedin_url }}" target="_blank" class="text-gray-400 hover:text-blue-700 transition">
                            <i class="fa-brands fa-linkedin text-xl"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Company Links --}}
            <div>
                <h4 class="text-white font-semibold text-lg mb-4">Company</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('gioi-thieu') }}" class="text-gray-400 hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition">Contact Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Send Feedback</a></li>
                </ul>
            </div>

            {{-- Account Links --}}
            <div>
                <h4 class="text-white font-semibold text-lg mb-4">Account</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('layouts') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                    <li><a href="{{ route('client.profile.index') }}" class="text-gray-400 hover:text-white transition">My Account</a></li>
                    <li><a href="{{ Auth::check() ? route('client.profile.orders') : route('login') }}" class="text-gray-400 hover:text-white transition">Order History</a></li>
                    <li><a href="{{ Auth::check() ? route('client.profile.favorite') : route('login') }}" class="text-gray-400 hover:text-white transition">Wishlist</a></li>
                </ul>
            </div>

            {{-- Policies --}}
            <div>
                <h4 class="text-white font-semibold text-lg mb-4">Policies</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('thong-tin-ban-hang') }}" class="text-gray-400 hover:text-white transition">Sales Info</a></li>
                    <li><a href="{{ route('dich-vu-ban-hang') }}" class="text-gray-400 hover:text-white transition">Sales Service</a></li>
                    <li><a href="{{ route('chinh-sach-bao-hanh') }}" class="text-gray-400 hover:text-white transition">Warranty</a></li>
                    <li><a href="{{ route('chinh-sach-doi-tra') }}" class="text-gray-400 hover:text-white transition">Returns</a></li>
                    <li><a href="{{ route('chinh-sach-van-chuyen') }}" class="text-gray-400 hover:text-white transition">Shipping</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="text-white font-semibold text-lg mb-4">Newsletter</h4>
                <p class="text-sm mb-4">Subscribe to get exclusive offers and latest collection updates!</p>
                <form class="flex flex-col gap-2">
                    <input
                        type="email"
                        placeholder="Enter your email"
                        class="px-3 py-2 bg-gray-800 text-white rounded-lg border border-gray-700 focus:outline-none focus:border-blue-500 text-sm"
                        required
                    >
                    <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium text-sm">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-gray-700 pt-8">
            <p class="text-center text-gray-400 text-sm">
                {{ $setting->copyright ?? '© ' . date('Y') . ' eShop. All rights reserved.' }}
            </p>
        </div>
    </div>
</footer>
