<x-user-layout title="{{ __('Invoice') }}">
    <section class="rounded-xl bg-surface p-5 text-on-surface-600 shadow-lg ring-1 ring-black/10 lg:p-10">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
            <div class="col-span-2 grid content-start gap-6 border-b border-black/10 pb-6 lg:border-b-0 lg:border-r lg:pb-0 lg:pr-6">
                <h1 class="text-center text-4xl font-black uppercase lg:text-left">{{ __('Invoice') }}</h1>
                <div><h2 class="text-xs font-bold uppercase text-on-surface-500">{{ __('Order ID') }}</h2><span>{{ $order->code }}</span></div>
                <div><h2 class="text-xs font-bold uppercase text-on-surface-500">{{ __('Issue date') }}</h2><span>{{ $order->created_at->format('Y-m-d') }} <small class="text-on-surface-500">({{ $order->created_at->diffForHumans() }})</small></span></div>
                <div><h2 class="text-xs font-bold uppercase text-on-surface-500">{{ __('Status') }}</h2><span class="rounded-full bg-amber-100 px-3 py-1 text-sm text-amber-900">{{ __('Processing') }}</span></div>
            </div>
            <div class="col-span-3 grid content-start gap-5">
                <div><h2 class="text-xs font-bold uppercase text-on-surface-500">{{ __('Full name') }}</h2><span>{{ $order->full_name }}</span></div>
                <div><h2 class="text-xs font-bold uppercase text-on-surface-500">{{ __('Email address') }}</h2><span>{{ $order->email }}</span></div>
                <div><h2 class="text-xs font-bold uppercase text-on-surface-500">{{ __('Phone number') }}</h2><span>{{ $order->phone_number }}</span></div>
                <div><h2 class="text-xs font-bold uppercase text-on-surface-500">{{ __('Shipping address') }}</h2><span>{{ $order->shipping_address }}</span></div>
                <div><h2 class="text-xs font-bold uppercase text-on-surface-500">{{ __('Notes') }}</h2><span>{{ $order->notes ?: '—' }}</span></div>
            </div>
        </div>
        <div class="mt-10 overflow-x-auto"><table class="w-full min-w-[500px] text-left"><thead class="border-b border-black/20 text-xs uppercase text-on-surface-500"><tr><th class="py-3">{{ __('Product') }}</th><th class="py-3">{{ __('Quantity') }}</th><th class="py-3 text-right">{{ __('Price') }}</th><th class="py-3 text-right">{{ __('Total') }}</th></tr></thead><tbody>@foreach($order->cart->items as $item)<tr class="border-b border-black/10"><td class="py-4">{{ $item->product->name }}</td><td class="py-4">{{ $item->quantity }}</td><td class="py-4 text-right">{{ $item->product->formatted_price }}</td><td class="py-4 text-right">{{ $item->product->getFormattedTotalAmount($item->quantity) }}</td></tr>@endforeach</tbody><tfoot><tr><th colspan="3" class="py-5 text-right text-lg">{{ __('Total') }}</th><th class="py-5 text-right text-xl">{{ $order->cart->formatted_total_amount }}</th></tr></tfoot></table></div>
        <div class="mt-6 flex flex-wrap justify-between gap-3"><a href="{{ route('homepage') }}" class="rounded-xl border border-black/10 px-5 py-3 font-semibold">← {{ __('Back to menu') }}</a><button type="button" onclick="window.print()" class="rounded-xl bg-primary-600 px-5 py-3 font-semibold text-white">{{ __('Print invoice') }}</button></div>
    </section>
</x-user-layout>
