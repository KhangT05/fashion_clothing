<header class="bg-white dark:bg-slate-900 shadow-sm border-b border-slate-200 dark:border-slate-800">
    <div class="flex items-center justify-between px-6 py-4 max-w-full">
        <div class="flex items-center gap-4 flex-1">
            <!-- Welcome Message -->
            <div class="text-sm text-slate-600 dark:text-slate-400">
                Welcome back, <span class="font-semibold text-slate-900 dark:text-slate-100">{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center gap-4">
            <!-- Dark Mode Toggle -->
            <x-DarkModeToggle />

            <!-- Notifications (Optional) -->
            <button type="button" class="p-2 text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100 transition">
                <i class="fa-solid fa-bell text-lg"></i>
            </button>

            <!-- User Menu -->
            <div class="relative">
                <button type="button" class="flex items-center gap-2 p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition" onclick="toggleUserMenu()">
                    <img src="{{ Auth::user()->avatar ?? asset('server/img/profile_small.jpg') }}"
                         alt="Profile" class="w-8 h-8 rounded-full">
                    <i class="fa-solid fa-chevron-down text-xs text-slate-600 dark:text-slate-400"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 z-50">
                    <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700">
                        <p class="font-semibold text-slate-900 dark:text-slate-100">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Administrator</p>
                    </div>
                    <a href="{{ route('auth.logout') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        menu.classList.toggle('hidden');
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('userMenu');
        const button = e.target.closest('button');
        if (!button?.contains(e.target) && !menu?.contains(e.target)) {
            menu?.classList.add('hidden');
        }
    });
</script>
