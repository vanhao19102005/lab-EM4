<div x-data="{offcanvas:false}" x-on:display-offcanvas.window="offcanvas=true" x-on:close-offcanvas.window="offcanvas=false" x-show="offcanvas" x-cloak class="fixed inset-0 z-50">
    <div class="absolute inset-0 bg-zinc-900/60" x-show="offcanvas" x-transition.opacity @click="offcanvas=false"></div>
    <aside class="absolute inset-y-0 right-0 flex w-full max-w-lg flex-col bg-surface shadow-2xl" x-show="offcanvas" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" @keydown.escape.window="offcanvas=false">
        <header class="flex items-center justify-between border-b border-on-surface/20 px-5 py-4"><h2 class="text-xl font-bold text-on-surface-700">{{ $title ?? __('Details') }}</h2><button type="button" class="rounded-full px-3 py-1 text-2xl hover:bg-black/5" @click="offcanvas=false" aria-label="{{ __('Close') }}">×</button></header>
        <div class="flex-1 overflow-y-auto p-5">{{ $body ?? $slot }}</div>
    </aside>
</div>
