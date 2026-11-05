@props(['label' => null, 'name', 'type' => 'text', 'placeholder' => null, 'value' => null])
<label class="flex flex-col text-sm font-semibold text-on-surface-600">
    @if($label)<span class="mb-2">{{ $label }}</span>@endif
    <input {{ $attributes->merge(['class' => 'w-full rounded-lg border border-zinc-300 bg-surface px-4 py-3 font-normal text-on-surface-700 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-200'.($errors->has($name) ? ' border-red-500' : '')]) }} type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}">
    @error($name)<span class="mt-1 text-xs font-normal text-red-600">{{ $message }}</span>@enderror
</label>
