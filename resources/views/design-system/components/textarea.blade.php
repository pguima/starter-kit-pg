@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'placeholder' => null,
    'helper' => null,
    'error' => null,
    'rows' => 3,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
])

@php
    $id = $id ?? $name ?? 'textarea-' . uniqid();
    
    $containerClass = 'flex flex-col gap-1.5 w-full';
    $labelClass = 'text-sm font-medium text-[var(--text-primary)]';
    
    $baseClass = 'w-full rounded-lg border bg-[var(--surface-card)] px-3 py-2 text-sm text-[var(--text-primary)] transition-all duration-200 placeholder:text-[var(--text-muted)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/20 disabled:cursor-not-allowed disabled:bg-[var(--surface-hover)] disabled:text-[var(--text-muted)]';
    
    $borderClass = $error 
        ? 'border-[var(--status-error)] focus:border-[var(--status-error)] focus:ring-[var(--status-error)]/20' 
        : 'border-[var(--border-default)] focus:border-[var(--color-primary)] hover:border-[var(--border-hover)]';

    $textareaClasses = implode(' ', [$baseClass, $borderClass]);
    
    $messageClass = 'text-xs';
    $errorClass = 'text-[var(--status-error)]';
    $helperClass = 'text-[var(--text-secondary)]';
@endphp

<div class="{{ $containerClass }}">
    @if ($label)
        <label for="{{ $id }}" class="{{ $labelClass }}">
            {{ $label }}
            @if ($required) <span class="text-[var(--status-error)]">*</span> @endif
        </label>
    @endif

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        @if($required) required @endif
        {{ $attributes->merge(['class' => $textareaClasses]) }}
    >{{ $slot }}</textarea>

    @if ($error)
        <p class="{{ $messageClass }} {{ $errorClass }}">{{ $error }}</p>
    @elseif ($helper)
        <p class="{{ $messageClass }} {{ $helperClass }}">{{ $helper }}</p>
    @endif
</div>
