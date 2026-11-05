@props(['header' => null, 'subHeader' => null, 'icon' => null])
<section {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl bg-surface shadow-sm ring-1 ring-black/10']) }}>
    @if($header || $subHeader)
        <div class="border-b border-black/10 px-5 py-4">
            <div class="flex items-center gap-2">
                @if($icon)<x-icon :icon="$icon" class="size-5 text-primary-600" />@endif
                @if($header)<h2 class="text-xl font-bold text-on-surface-700">{{ $header }}</h2>@endif
            </div>
            @if($subHeader)<p class="mt-1 text-sm font-normal text-on-surface-500">{{ $subHeader }}</p>@endif
        </div>
    @endif
    <div class="p-5">{{ $slot }}</div>
</section>
