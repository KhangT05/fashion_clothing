@props([
    'id' => 'modal',
    'title' => '',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div id="{{ $id }}" {{ $attributes->merge(['class' => 'hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4']) }}>
    <div class="{{ $sizeClass }} bg-white dark:bg-slate-900 rounded-lg shadow-lg">
        @if ($title)
            <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $title }}</h2>
                <button type="button" onclick="document.getElementById('{{ $id }}').classList.add('hidden')" class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
