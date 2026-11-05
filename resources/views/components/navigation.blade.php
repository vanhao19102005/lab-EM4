@props(['categories' => collect()])
<nav class="border-y border-black/10 bg-white/80 px-4 py-3" aria-label="{{ __('Categories') }}">
    <div class="mx-auto flex max-w-screen-xl gap-3 overflow-x-auto whitespace-nowrap">
        <a href="#menu" class="rounded-full bg-primary-600 px-4 py-2 text-sm font-semibold text-white">{{ __('Menu') }}</a>
        @foreach($categories as $category)
            <a href="#category_{{ $category->id }}" class="rounded-full px-4 py-2 text-sm font-semibold text-on-surface-600 hover:bg-primary-100">{{ $category->name }}</a>
        @endforeach
    </div>
</nav>
