<v-back-to-top></v-back-to-top>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-back-to-top-template"
    >
        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 translate-y-4 scale-90"
            enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0 scale-100"
            leave-to-class="opacity-0 translate-y-4 scale-90"
        >
            <button
                type="button"
                v-show="isVisible"
                @click="scrollToTop"
                class="fixed bottom-6 right-5 sm:bottom-8 sm:right-8 z-[90] flex items-center justify-center w-12 h-12 rounded-full shadow-2xl transition-all duration-300 hover:scale-110 hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-[#133b63]/30 group cursor-pointer"
                style="background-color: #133b63; color: #ffffff; border: 2px solid #ffffff; box-shadow: 0 10px 25px rgba(19, 59, 99, 0.45);"
                aria-label="Back to Top"
                title="Back to Top"
            >
                <!-- Upward Arrow Icon -->
                <i class="fa-solid fa-chevron-up text-white text-base transition-transform duration-300 group-hover:-translate-y-0.5"></i>
            </button>
        </transition>
    </script>

    <script type="module">
        app.component('v-back-to-top', {
            template: '#v-back-to-top-template',

            data() {
                return {
                    isVisible: false,
                };
            },

            mounted() {
                window.addEventListener('scroll', this.handleScroll, { passive: true });
                this.handleScroll();
            },

            beforeUnmount() {
                window.removeEventListener('scroll', this.handleScroll);
            },

            methods: {
                handleScroll() {
                    this.isVisible = window.scrollY > 300;
                },

                scrollToTop() {
                    const startY = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
                    if (startY <= 0) return;

                    // High precision requestAnimationFrame ease-in-out smooth scroll (guaranteed smooth in all browsers & settings)
                    const duration = Math.min(800, Math.max(350, Math.sqrt(startY) * 16));
                    const startTime = performance.now();

                    function easeInOutCubic(t) {
                        return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
                    }

                    let isCancelled = false;
                    const cancelEvents = ['wheel', 'touchmove', 'keydown'];
                    const onUserCancel = () => {
                        isCancelled = true;
                        cleanup();
                    };
                    const cleanup = () => {
                        cancelEvents.forEach(evt => window.removeEventListener(evt, onUserCancel, { passive: true }));
                    };
                    cancelEvents.forEach(evt => window.addEventListener(evt, onUserCancel, { passive: true }));

                    function step(currentTime) {
                        if (isCancelled) return;
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const ease = easeInOutCubic(progress);
                        const currentY = Math.round(startY * (1 - ease));

                        window.scrollTo(0, currentY);

                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            window.scrollTo(0, 0);
                            cleanup();
                        }
                    }

                    requestAnimationFrame(step);
                },
            },
        });
    </script>
@endpushOnce
