<div x-data x-show="$wire.display" x-transition x-cloak class="fixed inset-x-0 bottom-0 z-30 border-t border-black/10 bg-surface/95 px-3 py-3 shadow-2xl backdrop-blur">
    <div class="mx-auto flex max-w-screen-xl flex-col gap-3 lg:flex-row lg:items-center">
        <div class="flex min-w-0 grow items-center gap-3"><span class="grid size-10 shrink-0 place-items-center rounded-full bg-primary-100 text-xl">🛍</span>
            <ul class="flex flex-wrap gap-2">
                @foreach($cart->items as $item)
                    <li wire:key="cart-bar-{{ $item->id }}" class="flex items-center gap-2 rounded-lg border border-black/10 px-3 py-2 text-sm text-on-surface-600 hover:bg-primary-50" @click="Livewire.dispatch('USER_SELECT_PRODUCT_EVENT',{product_id:{{ $item->product_id }}})">
                        <span>{{ $item->quantity }}× {{ $item->product->name }}</span>
                        <button type="button" wire:click.stop="removeCartItem({{ $item->product_id }})" aria-label="{{ __('Remove') }}" class="text-lg leading-none text-on-surface-500 hover:text-red-600">×</button>
                    </li>
                @endforeach
            </ul>
        </div>
        <button type="button" wire:click="checkout" class="shrink-0 rounded-xl bg-primary-600 px-5 py-3 font-semibold text-white">{{ __('Checkout') }} · {{ $cart->formatted_total_amount }}</button>
    </div>
</div>
