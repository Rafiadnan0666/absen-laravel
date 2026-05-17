@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-neo-red font-bold']) }}>
        @foreach ((array) $messages as $message)
            <li>⚠️ {{ $message }}</li>
        @endforeach
    </ul>
@endif