<x-user-layout :title="__('Profile')">
    <section class="mx-auto w-full max-w-5xl space-y-6">
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <x-panel>
                <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div class="flex items-start gap-3">
                        <x-icon icon="info" class="mt-0.5 size-5 shrink-0 text-primary-600" />
                        <div class="text-sm text-on-surface-600">
                            <p>{{ __('Your email address is unverified.') }} <button form="send-verification" class="font-semibold text-primary-700 underline">{{ __('Resend verification email') }}</button></p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-primary-700">{{ __('A new verification link has been sent to your email address.') }}</p>
                            @endif
                        </div>
                    </div>
                </form>
            </x-panel>
        @endif

        <x-panel :header="__('Profile Information')" :sub-header="__('Update your account name and email address.')">
            @include('profile.partials.update-profile-information-form')
        </x-panel>

        <x-panel :header="__('Update Password')" :sub-header="__('Use a long, unique password to protect your account.')">
            @include('profile.partials.update-password-form')
        </x-panel>

        <x-panel id="two-factor-authentication" :header="__('Two-Factor Authentication')" :sub-header="__('Protect your account with an authenticator app and recovery codes.')">
            @include('profile.partials.two-factor-authentication')
        </x-panel>

        <x-panel :header="__('Delete Account')" :sub-header="__('Permanently remove your account.')">
            @include('profile.partials.delete-user-form')
        </x-panel>
    </section>
</x-user-layout>
