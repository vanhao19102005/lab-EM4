@props(['id', 'maxWidth' => '2xl'])
<x-modal :id="$id" :max-width="$maxWidth" {{ $attributes }}>
    <div class="px-5 py-5 sm:flex sm:items-start sm:gap-4">
        <div class="mx-auto grid size-11 shrink-0 place-items-center rounded-full bg-red-100 text-red-600 sm:mx-0">
            <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
        </div>
        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <h3 class="text-lg font-semibold text-on-surface-700">{{ $title }}</h3>
            <div class="mt-2 text-sm text-on-surface-600">{{ $content }}</div>
        </div>
    </div>
    <div class="flex flex-wrap justify-end gap-3 border-t border-black/10 bg-surface px-5 py-4">{{ $footer }}</div>
</x-modal>
