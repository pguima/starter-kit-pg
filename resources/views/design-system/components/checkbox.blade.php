@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'checked' => false,
    'disabled' => false,
    'error' => null,
    'helper' => null,
])

@php
    $id = $id ?? $name ?? 'checkbox-' . uniqid();
    
    $inputClass = 'peer h-4 w-4 shrink-0 cursor-pointer appearance-none rounded border border-[var(--border-default)] bg-[var(--surface-card)] transition-all checked:border-[var(--color-primary)] checked:bg-[var(--color-primary)] hover:border-[var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/20 disabled:cursor-not-allowed disabled:bg-[var(--surface-hover)] disabled:opacity-50';
    
    if ($error) {
        $inputClass .= ' border-[var(--status-error)]';
    }
@endphp

<div class="flex items-start">
    <div class="flex h-5 items-center">
        <input
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $attributes->class($inputClass) }}
        />
        <iconify-icon icon="solar:check-read-linear" class="pointer-events-none absolute h-4 w-4 text-[var(--text-on-primary)] opacity-0 transition-opacity peer-checked:opacity-100"></iconify-icon>
    </div>
    
    @if ($label)
        <div class="ml-2 text-sm">
            <label for="{{ $id }}" class="font-medium text-[var(--text-primary)] {{ $disabled ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }}">
                {{ $label }}
            </label>
            @if ($error)
                <p class="mt-1 text-xs text-[var(--status-error)]">{{ $error }}</p>
            @elseif ($helper)
                <p class="mt-1 text-xs text-[var(--text-secondary)]">{{ $helper }}</p>
            @endif
        </div>
    @endif
</div>
