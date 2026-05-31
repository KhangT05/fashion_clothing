@props([
    'label' => null,
    'type' => 'text',
    'name',
    'value' => null,
    'error' => false,
    'placeholder' => '',
])

@php
    $errorClass = $error ? 'border-red-500 focus:ring-red-500' : 'border-slate-300 focus:ring-indigo-500 dark:border-slate-600';
@endphp

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
            {{ $label }}
        </label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => "w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-0 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 $errorClass"]) }}
    />
    @if ($error)
        <span class="text-red-600 dark:text-red-400 text-sm mt-1 block">{{ $error }}</span>
    @endif
</div>
