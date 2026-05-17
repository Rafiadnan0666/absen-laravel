@props(['active'])

@php
$classes = ($active ?? false)
    ? 'neo-nav-link-active px-4 py-2'
    : 'neo-nav-link hover:bg-neo-yellow';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>