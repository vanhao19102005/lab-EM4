@props(['product'])
<article x-data class="flex min-h-40 w-full cursor-pointer flex-row rounded-xl bg-surface p-3 shadow-sm ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:shadow-lg" @click="Livewire.dispatch('USER_SELECT_PRODUCT_EVENT', { product_id: {{ $product->id }} })">
    <div class="h-28 w-28 shrink-0 overflow-hidden rounded-lg bg-zinc-100"><img class="h-full w-full object-cover" src="{{ $product->display_image_url }}" alt="{{ $product->name }}" loading="lazy"></div>
    <div class="ml-4 flex min-w-0 flex-1 flex-col">
        <div class="flex items-start justify-between gap-2"><h2 class="text-lg font-semibold text-on-surface-600">{{ $product->name }}</h2><span class="shrink-0 font-bold text-primary-700">{{ $product->formatted_price }}</span></div>
        <p class="mt-2 line-clamp-2 text-sm text-on-surface-500">{{ $product->description }}</p>
        <div class="mt-auto flex justify-end pt-3"><button type="button" class="grid size-8 place-items-center rounded-lg bg-primary-600 text-xl text-white" aria-label="{{ __('Add to cart') }}">+</button></div>
    </div>
</article>
