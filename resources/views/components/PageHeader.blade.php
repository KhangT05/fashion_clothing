@props([
    'title',
    'description' => null,
    'breadcrumbs' => [],
])

<div class="mb-8">
    @if ($breadcrumbs)
        <nav class="flex mb-4 text-sm" aria-label="Breadcrumb">
            <ol class="flex space-x-2">
                @foreach ($breadcrumbs as $label => $url)
                    <li>
                        <a href="{{ $url }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                            {{ $label }}
                        </a>
                    </li>
                    @if (!$loop->last)
                        <li class="text-slate-400">/</li>
                    @endif
                @endforeach
            </ol>
        </nav>
    @endif

    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $title }}</h1>
            @if ($description)
                <p class="mt-2 text-slate-600 dark:text-slate-400">{{ $description }}</p>
            @endif
        </div>
        <div class="flex gap-2">
            {{ $slot }}
        </div>
    </div>
</div>
