@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'neo-alert-success font-mono text-sm']) }}>
        ✓ {{ $status }}
    </div>
@endif
