<x-user-layout :title="__('Two Factor Authentication')">
    <section class="mx-auto w-full max-w-2xl" x-data="{ recovery: false }">
        <x-panel :header="__('Two Factor Authentication')">
            <p class="mb-4 text-sm text-on-surface-600" x-show="!recovery">{{ __('Enter the authentication code from your authenticator app.') }}</p>
            <p class="mb-4 text-sm text-on-surface-600" x-cloak x-show="recovery">{{ __('Enter one of your recovery codes.') }}</p>
            <form method="POST" action="{{ route('two-factor.login') }}" class="grid gap-5">
                @csrf
                <div x-show="!recovery">
                    <x-text-input type="text" name="code" :label="__('Authentication Code')" inputmode="numeric" autocomplete="one-time-code" autofocus />
                </div>
                <div x-cloak x-show="recovery">
                    <x-text-input type="text" name="recovery_code" :label="__('Recovery Code')" autocomplete="one-time-code" />
                </div>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <button type="button" class="text-sm text-primary-700 underline" x-on:click="recovery = !recovery">
                        <span x-show="!recovery">{{ __('Use a recovery code') }}</span>
                        <span x-cloak x-show="recovery">{{ __('Use an authentication code') }}</span>
                    </button>
                    <x-button type="submit">{{ __('Log in') }}</x-button>
                </div>
            </form>
        </x-panel>
    </section>
</x-user-layout>
