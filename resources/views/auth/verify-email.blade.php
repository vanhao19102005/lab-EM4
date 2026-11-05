<x-user-layout :title="__('Verify Email')">
    <section class="mx-auto w-full max-w-2xl">
        <x-panel :header="__('Verify your email address')" :sub-header="__('Please verify your email before continuing.')">
            @if (session('status') === 'verification-link-sent')
                <p class="mb-4 rounded-lg bg-primary-50 p-3 text-sm text-primary-800" role="status">{{ __('A new verification link has been sent to your email address.') }}</p>
            @endif
            <form method="POST" action="{{ route('verification.send') }}" class="flex flex-wrap items-center justify-between gap-4">
                @csrf
                <p class="text-sm text-on-surface-600">{{ __('If you did not receive the email, you can request another verification link.') }}</p>
                <x-button type="submit">{{ __('Resend verification email') }}</x-button>
            </form>
        </x-panel>
    </section>
</x-user-layout>
