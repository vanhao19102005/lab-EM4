@props(['id', 'maxWidth' => '2xl'])
@php($widthClass = match ($maxWidth) { 'sm' => 'max-w-sm', 'md' => 'max-w-md', 'lg' => 'max-w-lg', 'xl' => 'max-w-xl', default => 'max-w-2xl' })
<div
    x-data="{ open: false }"
    x-on:open-modal.window="if (($event.detail?.id ?? $event.detail) === @js($id)) open = true"
    x-on:close-modal.window="if (($event.detail?.id ?? $event.detail) === @js($id)) open = false"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
    style="display:none"
    role="dialog"
    aria-modal="true"
    {{ $attributes }}
>
    <div class="fixed inset-0 bg-black/50" @click="open=false"></div>
    <div class="relative mx-auto w-full {{ $widthClass }} overflow-hidden rounded-xl bg-surface shadow-xl">
        {{ $slot }}
    </div>
</div>
