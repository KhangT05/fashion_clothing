<aside class="w-64 bg-slate-900 dark:bg-slate-950 border-r border-slate-800 dark:border-slate-900 h-screen overflow-y-auto sticky top-0">
    <!-- Logo Section -->
    <div class="p-6 border-b border-slate-800">
        <h1 class="text-2xl font-bold text-white dark:text-slate-100">
            e<span class="text-indigo-500">Admin</span>
        </h1>
    </div>

    <!-- Navigation Menu -->
    <nav class="py-4">
        <!-- User Profile -->
        @auth
            <div class="px-6 py-4 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <img src="{{ Auth::user()->avatar ?? asset('server/img/profile_small.jpg') }}"
                         alt="Profile" class="w-10 h-10 rounded-full">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white dark:text-slate-100 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400">Admin</p>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('auth.logout') }}" class="block w-full px-3 py-2 text-sm text-slate-300 hover:bg-slate-800 dark:hover:bg-slate-800 rounded-lg transition">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                    </a>
                </div>
            </div>
        @endauth

        <!-- Menu Items -->
        @foreach (config('menu.module') as $key => $val)
            <div class="py-2 px-3">
                @if (isset($val['children']) && count($val['children']) > 0)
                    <!-- Collapsible Menu -->
                    <button type="button"
                            class="menu-toggle w-full flex items-center justify-between px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 dark:hover:bg-slate-800 hover:text-white transition"
                            data-menu="{{ $key }}">
                        <div class="flex items-center gap-3">
                            <i class="{{ $val['icon'] }} text-lg w-5"></i>
                            <span class="font-medium">{{ $val['title'] }}</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs menu-arrow"></i>
                    </button>

                    <!-- Submenu -->
                    <ul class="submenu hidden mt-1 space-y-1 ml-2 border-l-2 border-slate-700 pl-2" id="menu-{{ $key }}">
                        @foreach ($val['children'] as $children)
                            <li>
                                <a href="{{ isset($children['route']) && Route::has($children['route']) ? route($children['route']) : '#' }}"
                                   class="block px-3 py-2 text-sm text-slate-400 hover:text-slate-100 hover:bg-slate-800 dark:hover:bg-slate-800 rounded-lg transition">
                                    {{ $children['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <!-- Simple Link -->
                    <a href="{{ isset($val['route']) && Route::has($val['route']) ? route($val['route']) : '#' }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 dark:hover:bg-slate-800 hover:text-white transition">
                        <i class="{{ $val['icon'] }} text-lg w-5"></i>
                        <span class="font-medium">{{ $val['title'] }}</span>
                    </a>
                @endif
            </div>
        @endforeach
    </nav>
</aside>

<script>
    // Handle menu toggle
    document.querySelectorAll('.menu-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const menuKey = this.dataset.menu;
            const submenu = document.getElementById(`menu-${menuKey}`);
            const arrow = this.querySelector('.menu-arrow');

            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });
    });

    // Highlight active menu items
    document.querySelectorAll('a[href]').forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('bg-indigo-600', 'text-white');
            link.classList.remove('text-slate-300', 'hover:text-white');

            // Open parent menu if this is a submenu item
            const parent = link.closest('.submenu');
            if (parent) {
                parent.classList.remove('hidden');
                parent.parentElement.querySelector('.menu-toggle').querySelector('.menu-arrow').classList.add('rotate-180');
            }
        }
    });
</script>
