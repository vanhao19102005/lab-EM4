<x-user-layout title="{{ __('Checkout') }}">
    <section class="mt-3 px-2 py-2 lg:px-6">
        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <div class="mb-4 flex justify-end"><x-button :href="route('homepage')" class="bg-transparent text-primary-700 hover:bg-primary-50">← {{ __('Continue to shopping') }}</x-button></div>
            @error('cart')<p class="mb-4 rounded-lg bg-red-50 p-3 text-red-700">{{ $message }}</p>@enderror
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-5">
                <div class="col-span-3 grid grid-cols-1 gap-5">
                    <x-panel :header="__('Shipping address')">
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <x-text-input label="{{ __('Your name') }}" name="full_name" value="{{ old('full_name') }}" placeholder="{{ __('Please enter your name') }}" required />
                            <x-text-input label="{{ __('Phone number') }}" name="phone_number" value="{{ old('phone_number') }}" placeholder="{{ __('Please enter your phone number') }}" required />
                            <x-text-input class="sm:col-span-2" label="{{ __('Your email') }}" name="email" type="email" value="{{ old('email') }}" placeholder="{{ __('Please enter your email') }}" required />
                            <x-text-input class="sm:col-span-2" label="{{ __('Shipping address') }}" name="shipping_address" value="{{ old('shipping_address') }}" placeholder="{{ __('Please enter your address') }}" required />
                            <x-text-input class="sm:col-span-2" label="{{ __('Notes') }}" name="notes" value="{{ old('notes') }}" placeholder="{{ __('Please enter your note if any') }}" />
                        </div>
                    </x-panel>
                    <x-panel :header="__('Cart Items')">
                        @forelse($cart->items as $item)<div class="flex items-center gap-4 border-b border-black/10 py-4 last:border-0"><img class="size-20 rounded-lg object-cover" src="{{ $item->product->display_image_url }}" alt="{{ $item->product->name }}"><div class="grow"><h3 class="font-semibold">{{ $item->quantity }}× {{ $item->product->name }}</h3><p class="mt-1 text-sm text-on-surface-500">{{ $item->notes }}</p></div><span class="font-bold">{{ $item->product->getFormattedTotalAmount($item->quantity) }}</span></div>@empty<p>{{ __('Your cart is empty.') }}</p>@endforelse
                    </x-panel>
                </div>
                <aside class="col-span-2"><x-panel :header="__('Payments')" class="sticky top-4">
                    <x-text-input label="{{ __('Coupon') }}" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="{{ __('Please enter coupon code if any') }}" />
                    <ul class="mt-5 space-y-4 text-on-surface-600"><li class="flex justify-between"><span>{{ __('Subtotal') }}</span><strong>{{ $cart->formatted_total_amount }}</strong></li><li class="flex justify-between"><span>{{ __('Shipping Fee') }}</span><strong>{{ __('Free') }}</strong></li><li class="flex justify-between border-t border-black/10 pt-4 text-xl"><span>{{ __('Total') }}</span><strong>{{ $cart->formatted_total_amount }}</strong></li></ul>
                    <x-button type="submit" class="mt-6 w-full">{{ __('Send Order') }}</x-button>
                </x-panel></aside>
            </div>
        </form>
    </section>
</x-user-layout>
