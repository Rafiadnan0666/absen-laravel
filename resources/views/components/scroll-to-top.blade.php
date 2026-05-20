<div
    x-data="{ visible: false }"
    x-init="window.addEventListener('scroll', () => { visible = window.scrollY > 400; })"
    x-show="visible"
    x-transition:enter="bounce-in"
    x-transition:leave="fade-in-up"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="fixed bottom-6 right-6 z-[999] neo-btn-primary neo-btn-sm cursor-pointer shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all duration-200 pulse-glow"
    style="display: none;"
>
    ↑ TOP
</div>
