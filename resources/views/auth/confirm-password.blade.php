<x-user-layout :title="__('Confirm Password')">
    <section class="mx-auto w-full max-w-2xl">
        <x-panel :header="__('Confirm Password')" :sub-header="__('This is a secure area. Please confirm your password before continuing.')">
            <form method="POST" action="{{ route('password.confirm') }}" class="grid gap-5">
                @csrf
                <x-text-input type="password" name="password" :label="__('Password')" autocomplete="current-password" required autofocus />
                <div class="flex justify-end"><x-button type="submit">{{ __('Confirm') }}</x-button></div>
            </form>
        </x-panel>
    </section>
</x-user-layout>
