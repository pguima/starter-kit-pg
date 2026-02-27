@props([
    'headers' => [],
    'striped' => false,
    'hoverable' => true,
    'bordered' => false,
    'compact' => false,
    'checkbox' => false,
])

@php
    $wrapperClass = 'w-full overflow-hidden rounded-lg border border-[var(--border-subtle)] bg-[var(--surface-card)] shadow-[var(--shadow-sm)]';
    $tableClass = 'w-full text-left text-sm text-[var(--text-primary)]';
    
    $theadClass = 'border-b border-[var(--border-subtle)] bg-[var(--surface-hover)] text-xs font-medium uppercase tracking-wider text-[var(--text-secondary)]';
    $thClass = 'px-6 py-3 font-semibold';
    
    $tbodyClass = 'divide-y divide-[var(--border-subtle)] bg-[var(--surface-card)]';
    $trClass = implode(' ', array_filter([
        'transition-colors duration-150',
        $hoverable ? 'hover:bg-[var(--surface-hover)]' : '',
        $striped ? 'even:bg-[var(--surface-page)]' : '',
    ]));
    
    $tdBasePadding = $compact ? 'px-6 py-2' : 'px-6 py-4';
@endphp

<div {{ $attributes->merge(['class' => $wrapperClass]) }}>
    <div class="overflow-x-auto">
        <table class="{{ $tableClass }}">
            {{-- Header --}}
            <thead class="{{ $theadClass }}">
                <tr>
                    @if ($checkbox)
                        <th class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all" type="checkbox" class="h-4 w-4 rounded border-[var(--border-default)] bg-[var(--surface-card)] text-[var(--color-primary)] focus:ring-[var(--color-primary)]/20">
                            </div>
                        </th>
                    @endif

                    @if (count($headers) > 0)
                        @foreach ($headers as $header)
                            <th scope="col" class="{{ $thClass }}">
                                {{ $header }}
                            </th>
                        @endforeach
                    @else
                        {{ $thead ?? '' }}
                    @endif
                </tr>
            </thead>

            {{-- Body --}}
            <tbody class="{{ $tbodyClass }}">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    {{-- Footer / Pagination --}}
    @isset($footer)
        <div class="border-t border-[var(--border-subtle)] bg-[var(--surface-card)] px-6 py-4">
            {{ $footer }}
        </div>
    @endisset
</div>
