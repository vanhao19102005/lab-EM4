<x-user-layout :title="__('Reset Password')">
    <section class="mx-auto w-full max-w-2xl">
        <x-panel :header="__('Reset Password')" :sub-header="__('Choose a new password for your account.')">
            <form action="{{ route('password.update') }}" method="POST" class="grid gap-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <x-text-input name="email" type="email" :label="__('Email')" :value="old('email', $request->email)" autocomplete="username" required autofocus />
                <x-text-input name="password" type="password" :label="__('New Password')" autocomplete="new-password" required />
                <x-text-input name="password_confirmation" type="password" :label="__('Confirm Password')" autocomplete="new-password" required />
                <div class="flex justify-end"><x-button type="submit">{{ __('Reset Password') }}</x-button></div>
            </form>
        </x-panel>
    </section>
</x-user-layout>
