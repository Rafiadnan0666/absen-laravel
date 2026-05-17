@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'neo-input']) }}>
