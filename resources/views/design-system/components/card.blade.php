@props([
    'title' => null,
    'description' => null,
    'align' => 'left',
    'variant' => 'default',
    'padded' => true,
    'shadow' => true,
    'bordered' => true,
    'hoverable' => false,
])

@php
    $alignClass = match ($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };

    $variantClass = match ($variant) {
        'ghost' => 'bg-transparent',
        'elevated' => 'bg-[var(--surface-elevated)]',
        default => 'bg-[var(--surface-card)]',
    };

    $shadowClass = match (true) {
        !$shadow => '',
        $variant === 'elevated' => 'shadow-[var(--shadow-md)]',
        default => 'shadow-[var(--shadow-sm)]',
    };

    $hoverClass = $hoverable
        ? 'hover:shadow-[var(--shadow-md)] hover:border-[var(--border-default)] cursor-pointer'
        : '';

    $containerClass = implode(' ', array_filter([
        'overflow-hidden rounded-lg transition-all duration-200',
        $bordered ? 'border border-[var(--border-subtle)]' : '',
        $variantClass,
        $shadowClass,
        $hoverClass,
    ]));

    $bodyClass = implode(' ', array_filter([
        $padded ? 'p-6' : '',
        $alignClass,
    ]));
@endphp

<div {{ $attributes->class($containerClass) }}>
    @isset($media)
        <div class="overflow-hidden">
            {{ $media }}
        </div>
    @endisset

    @isset($header)
        <div class="border-b border-[var(--border-subtle)] bg-[var(--surface-card)] px-6 py-4">
            {{ $header }}
        </div>
    @endisset

    <div class="{{ $bodyClass }}">
        @if ($title)
            <div class="text-base font-semibold text-[var(--text-primary)]">
                {{ $title }}
            </div>
        @endif

        @if ($description)
            <div class="mt-2 text-sm text-[var(--text-secondary)]">
                {{ $description }}
            </div>
        @endif

        @if ($title || $description)
            <div class="mt-4">
                {{ $slot }}
            </div>
        @else
            {{ $slot }}
        @endif
    </div>

    @isset($footer)
        <div class="border-t border-[var(--border-subtle)] bg-[var(--surface-card)] px-6 py-4">
            {{ $footer }}
        </div>
    @endisset
</div>
