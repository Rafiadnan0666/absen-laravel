<button {{ $attributes->merge(['type' => 'button', 'class' => 'neo-btn-secondary']) }}>
    {{ $slot }}
</button>