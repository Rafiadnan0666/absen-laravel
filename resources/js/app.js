import './bootstrap';

import Chart from 'chart.js/auto';
window.Chart = Chart;

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('profileModal', {
        open: false,
        toggle() { this.open = !this.open; },
        openModal() { this.open = true; },
        closeModal() { this.open = false; },
    });
});

Alpine.start();
