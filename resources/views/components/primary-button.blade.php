<button {{ $attributes->merge(['type' => 'submit', 'class' => 'neo-btn-primary']) }}>
    {{ $slot }}
</button>