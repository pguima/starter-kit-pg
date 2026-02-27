@props([
    'tabs' => [],
    'defaultTab' => 0,
    'variant' => 'underline',
    'size' => 'md',
    'fullWidth' => false,
])

@php
    $tabsId = 'ds-tabs-' . uniqid();

    $navGapClass = match ($variant) {
        'pill' => 'gap-1',
        'button' => 'gap-2',
        default => 'gap-0',
    };

    $navBaseClass = match ($variant) {
        'pill' => 'rounded-lg bg-[var(--surface-hover)] p-1',
        'button' => 'rounded-lg bg-transparent',
        default => 'border-b border-[var(--border-default)]',
    };

    $tabPaddingClass = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-5 py-3 text-sm',
        default => 'px-4 py-2 text-sm',
    };

    $tabBaseClass = implode(' ', array_filter([
        'inline-flex items-center justify-center gap-2 font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/20',
        $tabPaddingClass,
        $fullWidth ? 'flex-1' : '',
    ]));

    $tabInactiveClass = match ($variant) {
        'pill' => 'rounded-md text-[var(--text-secondary)] hover:text-[var(--text-primary)]',
        'button' => 'rounded-md border border-[var(--border-default)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--surface-hover)]',
        default => 'border-b-2 border-transparent text-[var(--text-secondary)] hover:text-[var(--text-primary)]',
    };

    $tabActiveClass = match ($variant) {
        'pill' => 'rounded-md bg-[var(--surface-card)] text-[var(--color-primary)] shadow-[var(--shadow-sm)]',
        'button' => 'rounded-md border border-[var(--color-primary)] bg-[var(--color-primary-light)] text-[var(--color-primary)]',
        default => 'border-b-2 border-[var(--color-primary)] text-[var(--color-primary)]',
    };

    $tabDisabledClass = 'opacity-40 cursor-not-allowed pointer-events-none';
@endphp

<div
    {{ $attributes->class('w-full') }}
    x-data="{
        active: @js((int) $defaultTab),
        select(i) {
            if (this.isDisabled(i)) return;
            this.active = i;
        },
        isDisabled(i) {
            const disabled = @js(array_map(fn ($t) => (bool) ($t['disabled'] ?? false), $tabs));
            return !!disabled[i];
        }
    }"
>
    <div
        class="flex flex-wrap items-center {{ $navGapClass }} {{ $navBaseClass }}"
        role="tablist"
        aria-label="tabs"
    >
        @foreach ($tabs as $index => $tab)
            @php
                $label = $tab['label'] ?? '';
                $icon = $tab['icon'] ?? null;
                $badge = $tab['badge'] ?? null;
                $disabled = (bool) ($tab['disabled'] ?? false);

                $tabId = $tabsId . '-tab-' . $index;
                $panelId = $tabsId . '-panel-' . $index;
            @endphp

            <button
                type="button"
                id="{{ $tabId }}"
                role="tab"
                aria-controls="{{ $panelId }}"
                x-bind:aria-selected="active === {{ $index }} ? 'true' : 'false'"
                x-bind:tabindex="active === {{ $index }} ? 0 : -1"
                x-on:click="select({{ $index }})"
                @if ($disabled)
                    disabled
                    aria-disabled="true"
                @endif
                class="{{ $tabBaseClass }} {{ $disabled ? $tabDisabledClass : '' }}"
                x-bind:class="active === {{ $index }} ? '{{ $tabActiveClass }}' : '{{ $tabInactiveClass }}'"
            >
                @if ($icon)
                    <iconify-icon icon="{{ $icon }}" class="text-base"></iconify-icon>
                @endif

                <span class="truncate">{{ $label }}</span>

                @if ($badge)
                    <x-ds::badge style="soft" variant="info" size="sm">{{ $badge }}</x-ds::badge>
                @endif
            </button>
        @endforeach
    </div>

    <div class="mt-4">
        @foreach ($tabs as $index => $tab)
            @php
                $content = $tab['content'] ?? '';

                $tabId = $tabsId . '-tab-' . $index;
                $panelId = $tabsId . '-panel-' . $index;
            @endphp

            <div
                id="{{ $panelId }}"
                role="tabpanel"
                aria-labelledby="{{ $tabId }}"
                x-cloak
                x-show="active === {{ $index }}"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-x-1"
                x-transition:enter-end="opacity-100 translate-x-0"
                class="rounded-lg border border-[var(--border-subtle)] bg-[var(--surface-card)] p-5 text-sm text-[var(--text-secondary)]"
            >
                {{ $content }}
            </div>
        @endforeach
    </div>
</div>
