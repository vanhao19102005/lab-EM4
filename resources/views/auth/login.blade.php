<x-user-layout :title="__('Login')">
    <section class="mx-auto w-full max-w-2xl">
        <x-panel :header="__('Login')" :sub-header="__('Sign in to access your account.')">
            @if (session('status'))
                <p class="mb-4 rounded-lg bg-primary-50 p-3 text-sm text-primary-800" role="status">{{ __(session('status')) }}</p>
            @endif
            <form action="{{ route('login') }}" method="POST" class="grid gap-5">
                @csrf
                <x-text-input name="email" type="email" :label="__('Email')" :value="old('email')" autocomplete="username" required autofocus />
                <x-text-input name="password" type="password" :label="__('Password')" autocomplete="current-password" required />
                <label class="flex items-center gap-2 text-sm text-on-surface-600">
                    <input type="checkbox" name="remember" value="1" class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500">
                    <span>{{ __('Remember me') }}</span>
                </label>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-col gap-2">
                        <a class="text-sm text-primary-700 underline" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                        @if (Route::has('register'))
                            <a class="text-sm text-primary-700 underline" href="{{ route('register') }}">{{ __('Create an account') }}</a>
                        @endif
                    </div>
                    <x-button type="submit">{{ __('Login') }}</x-button>
                </div>
            </form>
        </x-panel>
    </section>
</x-user-layout>
