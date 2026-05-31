<nav class="bg-white dark:bg-slate-900 shadow-md sticky top-0 z-50 border-b border-slate-200 dark:border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <a href="{{ route('layouts') }}" class="flex-shrink-0">
                <span class="text-2xl font-bold text-slate-900 dark:text-slate-100">e<span class="font-extrabold text-indigo-600 dark:text-indigo-400">Shop</span></span>
            </a>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('client.products.index') }}" class="flex-1 mx-8">
                <div class="relative">
                    <input
                        type="text"
                        id="search-input"
                        autocomplete="off"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ request('keyword') }}"
                        placeholder="Search products..."
                        name="keyword"
                    />
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-4 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                        <i class="fa fa-search"></i>
                    </button>
                    <div id="search-results" class="hidden absolute top-full left-0 right-0 mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg z-50 max-h-96 overflow-y-auto"></div>
                </div>
            </form>

            {{-- Navigation Links & User Menu --}}
            <div class="flex items-center gap-6">
                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('layouts') }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Home</a>
                    <a href="{{ route('gioi-thieu') }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">About</a>
                    <a href="{{ route('client.products.index') }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Shop</a>
                    <a href="{{ route('blog') }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Blog</a>
                    <a href="{{ route('contact') }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Contact</a>
                </div>

                {{-- User Account --}}
                <div class="flex items-center gap-4">
                    {{-- Dark Mode Toggle --}}
                    <x-DarkModeToggle />

                    @if (Auth::check())
                        <div class="relative">
                            <button id="accountBtn" class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                <i class="fa fa-user text-lg"></i>
                            </button>
                            <div id="accountDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-lg shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden z-40">
                                <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700">
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Welcome</p>
                                    <p class="font-semibold text-slate-900 dark:text-slate-100 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                <a href="{{ route('client.profile.index') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                                    <i class="fa fa-user mr-2"></i>Profile
                                </a>
                                <a href="{{ route('auth.logout') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition border-t border-slate-200 dark:border-slate-700">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    @else
                        <button type="button" onclick="openLoginModal()" class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fa fa-user text-lg"></i>
                        </button>
                    @endif

                    {{-- Cart Icon --}}
                    <div class="cart-wrapper">
                        @include('client.components.badge-carts')
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- Login Modal --}}
<div id="loginModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center p-6 border-b border-slate-200 dark:border-slate-700">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Sign In</h2>
            <button onclick="closeLoginModal()" class="text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300">
                <i class="fa fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
                        placeholder="Enter your password"
                        required
                    >
                    @error('password')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500 text-white font-semibold py-2 rounded-lg transition mb-4">
                    Sign In
                </button>

                <p class="text-center text-sm text-slate-600 dark:text-slate-400 mb-4">
                    Don't have an account?
                    <button type="button" onclick="switchToRegister()" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold">
                        Sign Up
                    </button>
                </p>
            </form>
        </div>
    </div>
</div>

{{-- Register Modal --}}
<div id="registerModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center p-6 border-b border-slate-200 dark:border-slate-700">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Create Account</h2>
            <button onclick="closeRegisterModal()" class="text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300">
                <i class="fa fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('auth.register') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                        placeholder="Enter your full name"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
                        placeholder="Enter your password"
                        required
                    >
                    @error('password')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500 text-white font-semibold py-2 rounded-lg transition mb-4">
                    Create Account
                </button>

                <p class="text-center text-sm text-slate-600 dark:text-slate-400">
                    Already have an account?
                    <button type="button" onclick="switchToLogin()" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold">
                        Sign In
                    </button>
                </p>
            </form>
        </div>
    </div>
</div>

<script>
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    const accountBtn = document.getElementById('accountBtn');
    const accountDropdown = document.getElementById('accountDropdown');

    function openLoginModal() {
        loginModal.classList.remove('hidden');
        registerModal.classList.add('hidden');
    }

    function closeLoginModal() {
        loginModal.classList.add('hidden');
    }

    function closeRegisterModal() {
        registerModal.classList.add('hidden');
    }

    function switchToLogin() {
        loginModal.classList.remove('hidden');
        registerModal.classList.add('hidden');
    }

    function switchToRegister() {
        registerModal.classList.remove('hidden');
        loginModal.classList.add('hidden');
    }

    accountBtn?.addEventListener('click', function() {
        accountDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function(e) {
        if (!accountBtn?.contains(e.target) && !accountDropdown?.contains(e.target)) {
            accountDropdown?.classList.add('hidden');
        }
    });

    loginModal?.addEventListener('click', function(e) {
        if (e.target === loginModal) closeLoginModal();
    });

    registerModal?.addEventListener('click', function(e) {
        if (e.target === registerModal) closeRegisterModal();
    });
</script>
