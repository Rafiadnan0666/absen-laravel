@props(['value'])

<label {{ $attributes->merge(['class' => 'neo-label']) }}>
    {{ $value ?? $slot }}
</label>