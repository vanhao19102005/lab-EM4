<section>
    <form method="POST" action="{{ route('user-profile-information.update') }}" class="grid gap-5">
        @csrf @method('PUT')
        <x-text-input name="name" :label="__('Name')" :value="old('name', $user->name)" error-bags="updateProfileInformation" autocomplete="name" required />
        <x-text-input name="email" type="email" :label="__('Email')" :value="old('email', $user->email)" error-bags="updateProfileInformation" autocomplete="username" required />
        <div class="flex flex-wrap items-center gap-4"><x-button type="submit">{{ __('Save') }}</x-button>
            @if (session('status') === 'profile-information-updated')<span class="text-sm text-green-700" role="status">{{ __('Saved.') }}</span>@endif
        </div>
    </form>
</section>
