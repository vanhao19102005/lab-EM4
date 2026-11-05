<x-user-layout title="Bean & Bloom | Homepage">
    <x-slot:navigation><x-navigation :categories="$categories" /></x-slot:navigation>
    <section id="menu" class="rounded-2xl bg-gradient-to-r from-rose-100 to-teal-100 px-6 py-8 text-center">
        <p class="text-sm font-bold uppercase tracking-[.2em] text-primary-700">Bean &amp; Bloom</p>
        <h1 class="mt-2 text-3xl font-black text-on-background">{{ __('Good coffee, better mornings.') }}</h1>
        <p class="mx-auto mt-3 max-w-2xl text-on-surface-600">{{ __('Thoughtfully sourced beans and freshly made drinks, ready for your everyday ritual.') }}</p>
    </section>
    @forelse($categories as $category)
        <x-product-grids :category="$category" :products="$category->products" />
    @empty
        <x-panel header="{{ __('Our menu') }}"><p class="text-on-surface-500">{{ __('No products yet. Run the product seeder from Sections 1–3.') }}</p></x-panel>
    @endforelse
    <div class="min-h-[150px] w-full"></div>
    <x-slot:components>
        <livewire:checkout.cart-bar />
        <livewire:checkout.add-cart-item-popup />
    </x-slot:components>
</x-user-layout>
