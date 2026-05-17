<button {{ $attributes->merge(['type' => 'submit', 'class' => 'neo-btn-danger']) }}>
    {{ $slot }}
</button>