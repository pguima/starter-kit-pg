@props([
    'variant' => 'default', // default, bold, muted
])
@php
    $baseClass = 'px-6 py-4 whitespace-nowrap';

    $textClass = match ($variant) {
        'bold' => 'font-medium text-[var(--text-primary)]',
        'muted' => 'text-[var(--text-muted)]',
        default => 'text-[var(--text-secondary)]',
    };
@endphp

<td {{ $attributes->merge(['class' => "$baseClass $textClass"]) }}>
    {{ $slot }}
</td>
