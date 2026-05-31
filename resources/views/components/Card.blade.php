@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg shadow hover:shadow-md transition-shadow ' . $class]) }}>
    {{ $slot }}
</div>
