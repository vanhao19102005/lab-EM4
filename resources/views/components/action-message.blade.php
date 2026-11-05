@props(['on'])
<div
    x-data="{ shown: false, timeout: null }"
    x-on:{{ $on }}.window="clearTimeout(timeout); shown=true; timeout=setTimeout(() => shown=false, 2000)"
    x-show="shown"
    x-transition
    x-cloak
    {{ $attributes->merge(['class' => 'text-sm text-on-surface-600']) }}
>
    {{ $slot->isEmpty() ? __('Saved.') : $slot }}
</div>
