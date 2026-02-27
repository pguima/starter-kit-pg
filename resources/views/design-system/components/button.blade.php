@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false,
    'fullWidth' => false,
])

@php
    $isDisabled = $disabled || $loading;

    $base = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/20';

    $sizeClass = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs h-8 rounded-md',
        'lg' => 'px-5 py-3 text-base h-11 rounded-lg',
        'icon' => 'h-8 w-8 p-0 rounded-md',
        default => 'px-4 py-2 text-sm h-9 rounded-md',
    };

    $variantClass = match ($variant) {
        'secondary' => 'bg-[var(--surface-card)] text-[var(--text-primary)] border border-[var(--border-default)] hover:bg-[var(--surface-hover)] hover:border-[var(--border-hover)] shadow-[var(--shadow-xs)]',
        'outline' => 'border border-[var(--border-default)] bg-transparent text-[var(--text-primary)] hover:bg-[var(--surface-hover)] hover:border-[var(--border-hover)]',
        'ghost' => 'bg-transparent text-[var(--text-secondary)] hover:bg-[var(--surface-hover)] hover:text-[var(--text-primary)]',
        'link' => 'bg-transparent text-[var(--text-link)] hover:underline p-0 h-auto',
        'success' => 'bg-[var(--status-success)] text-white hover:opacity-90 shadow-[var(--shadow-xs)] hover:shadow-[var(--shadow-sm)]',
        'warning' => 'bg-[var(--status-warning)] text-white hover:opacity-90 shadow-[var(--shadow-xs)] hover:shadow-[var(--shadow-sm)]',
        'danger' => 'bg-[var(--status-error)] text-white hover:opacity-90 shadow-[var(--shadow-xs)] hover:shadow-[var(--shadow-sm)]',
        'info' => 'bg-[var(--status-info)] text-white hover:opacity-90 shadow-[var(--shadow-xs)] hover:shadow-[var(--shadow-sm)]',
        default => 'bg-[var(--color-primary)] text-[var(--text-on-primary)] hover:bg-[var(--color-primary-hover)] shadow-[var(--shadow-xs)] hover:shadow-[var(--shadow-sm)]',
    };

    $stateClass = $isDisabled ? 'opacity-40 cursor-not-allowed pointer-events-none' : '';
    $widthClass = $fullWidth ? 'w-full' : '';

    $classes = implode(' ', array_filter([$base, $sizeClass, $variantClass, $stateClass, $widthClass]));

    $tag = $href ? 'a' : 'button';

    $iconMarkup = null;
    if (! $loading && $icon) {
        $iconSize = match ($size) {
            'sm' => 'text-base',
            'lg' => 'text-xl',
            default => 'text-lg',
        };
        $iconMarkup = '<iconify-icon icon="' . e($icon) . '" class="' . $iconSize . '"></iconify-icon>';
    }

    $gapClass = ($iconMarkup || $loading) ? 'gap-2' : '';
@endphp

@if ($tag === 'a')
    <a
        href="{{ $isDisabled ? 'javascript:void(0)' : $href }}"
        aria-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        {{ $attributes->merge(['class' => $classes . ' ' . $gapClass]) }}
    >
        @if ($loading)
            <x-ds::spinner size="sm" variant="secondary" />
        @elseif ($iconMarkup && $iconPosition === 'left')
            {!! $iconMarkup !!}
        @endif

        @if (trim($slot) !== '')
            <span>{{ $slot }}</span>
        @endif

        @if (! $loading && $iconMarkup && $iconPosition === 'right')
            {!! $iconMarkup !!}
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $isDisabled ? 'disabled' : '' }}
        aria-busy="{{ $loading ? 'true' : 'false' }}"
        {{ $attributes->merge(['class' => $classes . ' ' . $gapClass]) }}
    >
        @if ($loading)
            <x-ds::spinner size="sm" variant="secondary" />
        @elseif ($iconMarkup && $iconPosition === 'left')
            {!! $iconMarkup !!}
        @endif

        @if (trim($slot) !== '')
            <span>{{ $slot }}</span>
        @endif

        @if (! $loading && $iconMarkup && $iconPosition === 'right')
            {!! $iconMarkup !!}
        @endif
    </button>
@endif
