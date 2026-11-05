<section>
    <form method="POST" action="{{ route('user-password.update') }}" class="grid gap-5">
        @csrf @method('PUT')
        <x-text-input type="password" name="current_password" :label="__('Current Password')" error-bags="updatePassword" autocomplete="current-password" required />
        <x-text-input type="password" name="password" :label="__('New Password')" error-bags="updatePassword" autocomplete="new-password" required />
        <x-text-input type="password" name="password_confirmation" :label="__('Confirm Password')" error-bags="updatePassword" autocomplete="new-password" required />
        <div class="flex flex-wrap items-center gap-4"><x-button type="submit">{{ __('Save') }}</x-button>
            @if (session('status') === 'password-updated')<span class="text-sm text-green-700" role="status">{{ __('Saved.') }}</span>@endif
        </div>
    </form>
</section>
