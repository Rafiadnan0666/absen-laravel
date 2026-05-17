@props(['active'])

@php
$classes = ($active ?? false)
    ? 'neo-sidebar-item-active w-full'
    : 'neo-sidebar-item w-full';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>