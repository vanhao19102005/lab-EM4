@props(['type' => 'button'])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-lg border border-zinc-300 bg-surface px-5 py-3 font-semibold text-on-surface-700 hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-primary-500']) }}>
    {{ $slot }}
</button>
