<section>
    <p class="mb-4 text-sm text-on-surface-600">{{ __('Permanently delete your account and its data. Confirm your password to continue.') }}</p>
    <x-danger-button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'confirm-user-deletion'}))">{{ __('Delete Account') }}</x-danger-button>
    <x-confirmation-modal id="confirm-user-deletion">
        <x-slot:title>{{ __('Delete your account?') }}</x-slot:title>
        <x-slot:content>
            {{ __('This action cannot be undone. Enter your current password to confirm account deletion.') }}
            <form id="delete-user-form" method="POST" action="{{ route('profile.destroy') }}" class="mt-5">
                @csrf @method('DELETE')
                <x-text-input name="password" type="password" :label="__('Current Password')" error-bags="userDeletion" autocomplete="current-password" required />
            </form>
        </x-slot:content>
        <x-slot:footer>
            <x-secondary-button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal', {detail: 'confirm-user-deletion'}))">{{ __('Cancel') }}</x-secondary-button>
            <x-danger-button type="submit" form="delete-user-form">{{ __('Delete Account') }}</x-danger-button>
        </x-slot:footer>
    </x-confirmation-modal>
</section>
