@props(['id', 'maxWidth' => '2xl'])
<x-modal :id="$id" :max-width="$maxWidth" {{ $attributes }}>
    @isset($title)<div class="border-b border-black/10 px-5 py-4 text-lg font-semibold text-on-surface-700">{{ $title }}</div>@endisset
    <div class="px-5 py-4 text-sm text-on-surface-600">{{ $content }}</div>
    <div class="flex flex-wrap justify-end gap-3 border-t border-black/10 px-5 py-4">{{ $footer }}</div>
</x-modal>
