<x-user-layout :title="__('Dashboard')">
    <section class="mx-auto w-full max-w-5xl">
        <x-panel :header="__('Dashboard')" :sub-header="__('Your account security and profile settings.')">
            <p class="text-on-surface-600">{{ __('Hello') }}, <strong>{{ auth()->user()->name }}</strong>. {{ __("You're logged in!") }}</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <x-button href="{{ route('profile.edit') }}" target="_self">{{ __('Profile Settings') }}</x-button>
                <x-button href="{{ route('apiTokens.index') }}" target="_self">{{ __('API Tokens') }}</x-button>
            </div>
        </x-panel>
    </section>
</x-user-layout>
