@props([
    'columns' => [],
    'responsive' => true,
])

<div @if($responsive) class="overflow-x-auto" @endif>
    <table class="w-full">
        @if ($columns)
            <thead class="bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                <tr>
                    @foreach ($columns as $column)
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            {{ $column }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            {{ $slot }}
        </tbody>
    </table>
</div>
