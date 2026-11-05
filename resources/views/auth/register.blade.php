<x-user-layout :title="__('Register')">
    <section class="mx-auto w-full max-w-2xl">
        <x-panel :header="__('Create your account')" :sub-header="__('Register to manage your coffee orders and account settings.')">
            <form action="{{ route('register') }}" method="POST" class="grid gap-5">
                @csrf
                <x-text-input name="name" :label="__('Name')" :value="old('name')" autocomplete="name" required autofocus />
                <x-text-input name="email" type="email" :label="__('Email')" :value="old('email')" autocomplete="username" required />
                <x-text-input name="password" type="password" :label="__('Password')" autocomplete="new-password" required />
                <x-text-input name="password_confirmation" type="password" :label="__('Confirm Password')" autocomplete="new-password" required />
                <div class="flex items-center justify-between gap-4">
                    <a class="text-sm text-primary-700 underline" href="{{ route('login') }}">{{ __('Already registered?') }}</a>
                    <x-button type="submit">{{ __('Register') }}</x-button>
                </div>
            </form>
        </x-panel>
    </section>
</x-user-layout>
