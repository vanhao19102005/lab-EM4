<section>
    @if (! auth()->user()->hasEnabledTwoFactorAuthentication())
        @if (session('status') === 'two-factor-authentication-enabled')
            <form method="POST" action="{{ route('two-factor.confirm') }}" class="grid gap-5">
                @csrf
                <p class="text-sm text-on-surface-600">{{ __('Scan this QR code with an authenticator app, then enter the generated code to finish enabling two-factor authentication.') }}</p>
                <div class="w-fit rounded-lg bg-white p-4">{!! auth()->user()->twoFactorQrCodeSvg() !!}</div>
                <p class="break-all text-sm text-on-surface-600"><strong>{{ __('Setup Key') }}:</strong> {{ decrypt(auth()->user()->two_factor_secret) }}</p>
                <x-text-input type="text" name="code" :label="__('Authentication Code')" inputmode="numeric" autocomplete="one-time-code" required />
                <div><x-button type="submit">{{ __('Confirm') }}</x-button></div>
            </form>
        @else
            <form method="POST" action="{{ route('two-factor.enable') }}" class="grid gap-4">
                @csrf
                <p class="text-sm text-on-surface-600">{{ __('Add an authenticator app as a second verification step when signing in.') }}</p>
                <div><x-button type="submit">{{ __('Enable Two-Factor Authentication') }}</x-button></div>
            </form>
        @endif
    @else
        <p class="mb-4 text-sm font-semibold text-on-surface-700">{{ __('Two-factor authentication is enabled for your account.') }}</p>
        <details class="mb-4 rounded-lg border border-black/10 p-4">
            <summary class="cursor-pointer font-semibold text-on-surface-600">{{ __('Recovery Codes') }}</summary>
            <p class="my-3 text-sm text-on-surface-500">{{ __('Keep these codes somewhere safe. Each code can be used once if you lose access to your authenticator.') }}</p>
            <div class="rounded-lg bg-primary-50 p-4 font-mono text-sm text-on-surface-700">
                @foreach (auth()->user()->recoveryCodes() as $code)
                    <div>{{ $code }}</div>
                @endforeach
            </div>
            <form method="POST" action="{{ route('two-factor.recovery-codes') }}" class="mt-4">
                @csrf
                <x-secondary-button type="submit">{{ __('Regenerate Recovery Codes') }}</x-secondary-button>
            </form>
        </details>
        <form method="POST" action="{{ route('two-factor.disable') }}">
            @csrf
            @method('DELETE')
            <x-danger-button type="submit">{{ __('Disable Two-Factor Authentication') }}</x-danger-button>
        </form>
    @endif
</section>
