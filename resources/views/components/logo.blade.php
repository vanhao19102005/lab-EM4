@props(['hasSetting' => false])
<div {{ $attributes->merge(['class' => 'relative flex items-center justify-center bg-surface px-4 py-4']) }}>
    <a href="{{ route('homepage') }}" class="flex items-center gap-3 text-2xl font-black tracking-tight text-primary-700">
        <span class="grid size-11 place-items-center rounded-full bg-primary-600 text-xl text-white">☕</span>
        <span>Bean &amp; Bloom</span>
    </a>
    @if($hasSetting)
        <div class="absolute right-4 top-1/2 -translate-y-1/2"><livewire:setting-dropdown /></div>
    @endif
</div>
