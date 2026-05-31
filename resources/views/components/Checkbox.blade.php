@props([
    'label' => null,
    'name',
    'value' => '1',
    'error' => false,
])

<div class="mb-4">
    <label class="flex items-center">
        <input
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            @if(old($name, false)) checked @endif
            {{ $attributes->merge(['class' => 'w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-2 focus:ring-indigo-500 dark:bg-slate-800 dark:border-slate-600 cursor-pointer']) }}
        />
        @if ($label)
            <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">{{ $label }}</span>
        @endif
    </label>
    @if ($error)
        <span class="text-red-600 dark:text-red-400 text-sm mt-1 block">{{ $error }}</span>
    @endif
</div>
