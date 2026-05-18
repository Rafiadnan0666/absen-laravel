import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('tableFilter', function (filters = {}) {
    return {
        filters: filters,
        loading: false,

        init() {
            const container = this.$el.querySelector('[data-table-container]');
            if (container) {
                this.$el._initialHtml = container.innerHTML;
            }
        },

        buildUrl() {
            const params = new URLSearchParams();
            params.set('ajax', '1');
            for (const [key, value] of Object.entries(this.filters)) {
                if (value || value === '0') params.set(key, value);
            }
            return window.location.pathname + '?' + params.toString();
        },

        async fetch() {
            this.loading = true;
            try {
                const response = await fetch(this.buildUrl(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                const container = this.$el.querySelector('[data-table-container]');
                if (container) container.innerHTML = html;
                history.replaceState(null, '', this.buildUrl().replace('ajax=1', ''));
            } catch (e) {
                console.error('Filter error:', e);
            } finally {
                this.loading = false;
            }
        }
    };
});

document.addEventListener('alpine:init', () => {
    Alpine.store('profileModal', {
        open: false,
        toggle() { this.open = !this.open; },
        openModal() { this.open = true; },
        closeModal() { this.open = false; },
    });
});

Alpine.start();
