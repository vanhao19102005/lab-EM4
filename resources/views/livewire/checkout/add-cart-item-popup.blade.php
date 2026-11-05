<x-offcanvas>
    <x-slot:title>{{ $product?->name ?? __('Add to cart') }}</x-slot:title>
    <x-slot:body>
        @if($product)
            <div class="grid grid-cols-1 gap-5">
                <img class="h-64 w-full rounded-xl object-cover" src="{{ $product->display_image_url }}" alt="{{ $product->name }}">
                <span class="text-2xl font-bold text-on-surface-700">{{ $product->formatted_price }}</span>
                <p class="max-h-32 overflow-y-auto text-on-surface-500">{{ $product->description }}</p>
                <label class="text-sm font-medium text-on-surface-600">{{ __('Special instructions') }}
                    <textarea wire:model="notes" rows="2" maxlength="500" class="mt-2 w-full rounded-lg border border-zinc-300 bg-surface p-3" placeholder="{{ __('Ex. No onions please') }}"></textarea>
                </label>
                @error('quantity')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
                @error('notes')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-4 rounded-lg border border-black/10 p-2"><button type="button" wire:click="decrement" aria-label="{{ __('Decrease quantity') }}">−</button><span class="min-w-6 text-center text-xl font-bold">{{ $quantity }}</span><button type="button" wire:click="increment" aria-label="{{ __('Increase quantity') }}">+</button></div>
                    <button type="button" wire:click="addCartItem" class="grow rounded-lg bg-primary-600 px-4 py-3 font-semibold text-white">{{ __('Add to cart') }} · {{ $product->getFormattedTotalAmount($quantity) }}</button>
                </div>
            </div>
        @endif
    </x-slot:body>
</x-offcanvas>
