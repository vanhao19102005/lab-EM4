@props(['label' => null, 'name', 'type' => 'text', 'placeholder' => null, 'value' => null, 'model' => null, 'errorBags' => null])
@php
    $inputErrors = $errorBags ? $errors->getBag($errorBags) : $errors;
    $hasError = $inputErrors->has($name);
@endphp
<label class="flex flex-col text-sm font-semibold text-on-surface-600">
    @if($label)<span class="mb-2">{{ $label }}</span>@endif
    <input
        {{ $attributes->merge(['class' => 'w-full rounded-lg border border-zinc-300 bg-surface px-4 py-3 font-normal text-on-surface-700 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-200'.($hasError ? ' border-red-500' : '')]) }}
        type="{{ $type }}"
        name="{{ $name }}"
        @if($model) wire:model="{{ $model }}" @else value="{{ old($name, $value) }}" @endif
        placeholder="{{ $placeholder }}"
    >
    @if($hasError)<span class="mt-1 text-xs font-normal text-red-600">{{ $inputErrors->first($name) }}</span>@endif
</label>
