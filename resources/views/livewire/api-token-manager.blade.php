<div class="space-y-8">
    <form wire:submit="createToken" class="grid gap-5 rounded-xl border border-black/10 p-5">
        <x-text-input name="name" label="Token name" wire:model="name" placeholder="e.g. local development" required />
        <fieldset><legend class="mb-2 text-sm font-semibold text-on-surface-600">Permissions</legend><div class="flex flex-wrap gap-x-5 gap-y-3">
            @foreach ($availableAbilities as $ability)
                <label class="inline-flex items-center gap-2 text-sm capitalize text-on-surface-600"><input type="checkbox" wire:model="abilities" value="{{ $ability }}" class="size-4 rounded border-zinc-300 text-primary-600 focus:ring-primary-500">{{ $ability }}</label>
            @endforeach
        </div></fieldset>
        @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        @error('abilities')<p class="text-sm text-red-600">Choose at least one permission.</p>@enderror
        @error('abilities.*')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        <div><x-button type="submit">Create token</x-button></div>
    </form>
    <div class="space-y-3"><h3 class="font-bold text-on-surface-700">Your tokens</h3>
        @forelse ($tokens as $token)
            <article wire:key="token-{{ $token->id }}" class="flex flex-col justify-between gap-4 rounded-xl border border-black/10 p-4 sm:flex-row sm:items-center">
                <div class="min-w-0"><p class="truncate font-semibold text-on-surface-700">{{ $token->name }}</p><p class="mt-1 text-sm text-on-surface-500">Permissions: {{ implode(', ', $token->abilities) ?: 'none' }}</p><p class="mt-1 text-xs text-on-surface-500">Last used: {{ $token->last_used_at?->diffForHumans() ?? 'Never' }} · Created {{ $token->created_at->diffForHumans() }}</p></div>
                <div class="flex shrink-0 gap-2"><x-secondary-button type="button" wire:click="editToken({{ $token->id }})">Edit permissions</x-secondary-button><x-danger-button type="button" wire:click="deleteToken({{ $token->id }})" wire:confirm="Revoke this token?">Revoke</x-danger-button></div>
            </article>
        @empty
            <p class="rounded-xl border border-dashed border-black/20 p-6 text-center text-sm text-on-surface-500">No API tokens yet.</p>
        @endforelse
    </div>
    <x-modal id="show-api-token"><div class="space-y-4 p-6"><h2 class="text-xl font-bold text-on-surface-700">Copy your new token now</h2><p class="text-sm text-on-surface-600">For security, this token will not be shown again after you close this window.</p>
        <div class="break-all rounded-lg bg-primary-50 p-4 font-mono text-sm text-on-surface-700" x-data="{copied:false}"><code>{{ $plainTextToken }}</code><button type="button" class="ml-2 text-primary-700 underline" @click="navigator.clipboard.writeText($el.previousElementSibling.textContent.trim());copied=true">Copy</button><span x-show="copied" class="ml-2 text-xs text-green-700">Copied</span></div>
        <div class="flex justify-end"><x-button type="button" wire:click="dismissPlainTextToken">Done</x-button></div>
    </div></x-modal>
    <x-modal id="edit-api-token"><form wire:submit="updateToken" class="space-y-5 p-6"><h2 class="text-xl font-bold text-on-surface-700">Edit token permissions</h2><div class="flex flex-wrap gap-x-5 gap-y-3">
        @foreach ($availableAbilities as $ability)
            <label class="inline-flex items-center gap-2 text-sm capitalize text-on-surface-600"><input type="checkbox" wire:model="editingAbilities" value="{{ $ability }}" class="size-4 rounded border-zinc-300 text-primary-600 focus:ring-primary-500">{{ $ability }}</label>
        @endforeach
    </div>@error('editingAbilities')<p class="text-sm text-red-600">Choose at least one permission.</p>@enderror<div class="flex justify-end gap-2"><x-secondary-button type="button" x-on:click="$dispatch('close-modal',{id:'edit-api-token'})">Cancel</x-secondary-button><x-button type="submit">Save permissions</x-button></div></form></x-modal>
</div>
