@props(['category', 'products'])
<section class="scroll-mt-28 px-2 py-2 lg:px-4" id="category_{{ $category->id }}">
    <h2 class="py-5 text-3xl font-bold text-on-background">{{ $category->name }}</h2>
    @if($category->description)<p class="mb-5 text-on-surface-500">{{ $category->description }}</p>@endif
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        @foreach($products as $product)<x-product-card :product="$product" />@endforeach
    </div>
</section>
