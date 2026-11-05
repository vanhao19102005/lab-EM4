@props(['title' => 'Bean & Bloom'])
<x-base-layout :page-title="$title">
    <x-logo :has-setting="true" />
    @if(isset($navigation)) {{ $navigation }} @endif
    <main class="mx-auto grid w-full max-w-screen-xl grid-cols-1 gap-8 p-4 lg:p-10">
        {{ $slot }}
    </main>
    @if(isset($components)) {{ $components }} @endif
</x-base-layout>
