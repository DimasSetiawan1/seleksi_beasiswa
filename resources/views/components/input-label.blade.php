@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs text-slate-300 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
