@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'type' => 'text',
    'placeholder' => null,
    'helper' => null,
    'error' => null,
    'icon' => null,
    'rightIcon' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'size' => 'md',
])

@php
    $id = $id ?? $name ?? 'input-' . uniqid();
    
    // Classes de container
    $containerClass = 'flex flex-col gap-1.5 w-full';
    
    // Classes de Label
    $labelClass = 'text-sm font-medium text-[var(--text-primary)]';
    
    // Classes de Input Base
    $baseClass = 'w-full appearance-none rounded-lg border bg-[var(--surface-card)] text-[var(--text-primary)] transition-all duration-200 placeholder:text-[var(--text-muted)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/20 disabled:cursor-not-allowed disabled:bg-[var(--surface-hover)] disabled:text-[var(--text-muted)]';
    
    $borderClass = $error 
        ? 'border-[var(--status-error)] focus:border-[var(--status-error)] focus:ring-[var(--status-error)]/20' 
        : 'border-[var(--border-default)] focus:border-[var(--color-primary)] hover:border-[var(--border-hover)]';

    $sizeClass = match ($size) {
        'sm' => 'h-8 px-2.5 text-xs',
        'lg' => 'h-12 px-4 text-base',
        default => 'h-10 px-3 text-sm',
    };
    
    // Padding para ícones
    $paddingClass = '';
    if ($icon && $rightIcon) {
        $paddingClass = match ($size) {
            'sm' => 'pl-8 pr-8',
            'lg' => 'pl-11 pr-11',
            default => 'pl-10 pr-10',
        };
    } elseif ($icon) {
        $paddingClass = match ($size) {
            'sm' => 'pl-8',
            'lg' => 'pl-11',
            default => 'pl-10',
        };
    } elseif ($rightIcon) {
        $paddingClass = match ($size) {
            'sm' => 'pr-8',
            'lg' => 'pr-11',
            default => 'pr-10',
        };
    }
    
    $inputClasses = implode(' ', [$baseClass, $borderClass, $sizeClass, $paddingClass]);
    
    // Mensagens
    $messageClass = 'text-xs';
    $errorClass = 'text-[var(--status-error)]';
    $helperClass = 'text-[var(--text-secondary)]';
@endphp

<div class="{{ $containerClass }}">
    {{-- Label --}}
    @if ($label)
        <label for="{{ $id }}" class="{{ $labelClass }}">
            {{ $label }}
            @if ($required) <span class="text-[var(--status-error)]">*</span> @endif
        </label>
    @endif

    <div class="relative">
        {{-- Icon Left --}}
        @if ($icon)
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-[var(--text-secondary)]">
                <iconify-icon icon="{{ $icon }}" class="{{ $size === 'sm' ? 'text-sm' : ($size === 'lg' ? 'text-xl' : 'text-lg') }}"></iconify-icon>
            </div>
        @endif

        {{-- Input --}}
        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($required) required @endif
            {{ $attributes->merge(['class' => $inputClasses]) }}
        />

        {{-- Icon Right --}}
        @if ($rightIcon)
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-[var(--text-secondary)]">
                <iconify-icon icon="{{ $rightIcon }}" class="{{ $size === 'sm' ? 'text-sm' : ($size === 'lg' ? 'text-xl' : 'text-lg') }}"></iconify-icon>
            </div>
        @endif
    </div>

    {{-- Error / Helper --}}
    @if ($error)
        <p class="{{ $messageClass }} {{ $errorClass }}">{{ $error }}</p>
    @elseif ($helper)
        <p class="{{ $messageClass }} {{ $helperClass }}">{{ $helper }}</p>
    @endif
</div>
