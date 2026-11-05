<x-user-layout title="{{ __('Order complete') }}">
    <section class="mx-auto flex max-w-3xl flex-col items-center justify-center rounded-2xl bg-surface px-6 py-14 text-center shadow-sm ring-1 ring-black/10">
        <div class="grid size-24 place-items-center rounded-full bg-primary-100 text-5xl text-primary-700">✓</div>
        <h1 class="mt-6 text-4xl font-black uppercase text-on-background">{{ __('Thank you') }}!</h1>
        <h2 class="mt-3 text-on-background">{{ __('Your order number is') }} <span class="font-bold">{{ $order->code }}</span></h2>
        <p class="mt-5 max-w-xl text-on-surface-500">{{ __('We are getting started on your order right away, and you will receive an order confirmation email shortly at') }} <strong class="text-on-background">{{ $order->email }}</strong>.</p>
        <x-button :href="$order->getCheckoutConfirmationPath()" class="mt-6">{{ __('View order confirmation') }}</x-button>
        <a class="mt-4 text-sm font-semibold text-primary-700 underline" href="{{ route('homepage') }}">{{ __('Continue to shopping') }}</a>
    </section>
</x-user-layout>
