@props([
    'href' => '#',
    'variant' => 'primary', // primary, secondary, danger, muted, ghost
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'iconPosition' => 'left', // left, right
    'external' => false,
    'underline' => 'hover', // none, always, hover
    'disabled' => false,
])

@php
    $baseClass = 'inline-flex items-center gap-1.5 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/20 rounded-sm cursor-pointer';

    // Variantes de cor
    $variantClass = match ($variant) {
        'secondary' => 'text-[var(--text-secondary)] hover:text-[var(--text-primary)]',
        'danger' => 'text-[var(--status-error)] hover:text-[var(--status-error)]/80',
        'muted' => 'text-[var(--text-muted)] hover:text-[var(--text-secondary)]',
        'ghost' => 'text-[var(--text-primary)] hover:text-[var(--color-primary)]', // Notion-style default text link usually acts like this
        default => 'text-[var(--color-primary)] hover:text-[var(--color-primary-hover)]',
    };

    // Tamanhos
    $sizeClass = match ($size) {
        'sm' => 'text-xs',
        'lg' => 'text-base',
        default => 'text-sm',
    };

    // Sublinhado
    $underlineClass = match ($underline) {
        'always' => 'underline underline-offset-4',
        'none' => 'no-underline',
        default => 'no-underline hover:underline underline-offset-4',
    };

    // Classes finais
    $classes = implode(' ', [
        $baseClass,
        $variantClass,
        $sizeClass,
        $underlineClass,
        $disabled ? 'pointer-events-none opacity-50' : '',
    ]);

    // Atributos externos
    $externalAttrs = $external ? 'target="_blank" rel="noopener noreferrer"' : '';

    // Ícone externo automático se não houver ícone definido e for externo
    $showExternalIcon = $external && !$icon;
@endphp
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }} {!! $externalAttrs !!}>
@if ($icon && $iconPosition === 'left')
    <iconify-icon icon="{{ $icon }}"></iconify-icon>
@endif

    <span>{{ $slot }}</span>

    @if ($icon && $iconPosition === 'right')
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @elseif ($showExternalIcon)
        <iconify-icon icon="solar:arrow-right-up-linear" class="text-[0.9em]"></iconify-icon>
    @endif
</a>
