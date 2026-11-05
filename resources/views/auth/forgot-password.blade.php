<x-user-layout :title="__('Reset Password')">
    <section class="mx-auto w-full max-w-2xl">
        <x-panel :header="__('Forgot Password')" :sub-header="__('Enter your email and we will send you a password reset link.')">
            @if (session('status'))
                <p class="mb-4 rounded-lg bg-primary-50 p-3 text-sm text-primary-800" role="status">{{ __(session('status')) }}</p>
            @endif
            <form action="{{ route('password.email') }}" method="POST" class="grid gap-5">
                @csrf
                <x-text-input name="email" type="email" :label="__('Email')" :value="old('email')" autocomplete="username" required autofocus />
                <div class="flex items-center justify-between">
                    <a class="text-sm text-primary-700 underline" href="{{ route('login') }}">{{ __('Back to login') }}</a>
                    <x-button type="submit">{{ __('Send password reset link') }}</x-button>
                </div>
            </form>
        </x-panel>
    </section>
</x-user-layout>
