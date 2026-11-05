@props(['header' => null])
<section {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl bg-surface shadow-sm ring-1 ring-black/10']) }}>
    @if($header)<h2 class="border-b border-black/10 px-5 py-4 text-xl font-bold text-on-surface-700">{{ $header }}</h2>@endif
    <div class="p-5">{{ $slot }}</div>
</section>
