{!! view_render_event('bagisto.shop.layout.header.before') !!}

<div class="relative z-50 max-lg:hidden">
    <x-shop::layouts.header.desktop.top />
</div>

<header class="sticky top-0 z-40 border-b border-soxnsox-border/80 bg-white/95 backdrop-blur-md shadow-soxnsox-subtle transition-all duration-300">
    <v-header-switcher>
        <!-- Desktop Header Shimmer -->
        <div class="flex flex-wrap max-lg:hidden">
            <div class="mx-auto flex min-h-[84px] w-full max-w-7xl items-center justify-between px-6 lg:px-12">
                <!-- Left: Logo -->
                <div class="flex flex-col">
                    <span class="font-display text-2xl lg:text-3xl font-extrabold tracking-tight text-[#133b63]">
                        SOX<span class="text-[#f29a38]">N</span>SOX
                    </span>
                    <span class="text-[9px] tracking-[0.28em] uppercase text-[#2ca7a3] -mt-0.5 font-sans font-bold">
                        Bamboo Socks
                    </span>
                </div>

                <!-- Center Navigation -->
                <div class="flex items-center gap-7">
                    <span class="w-12 h-4 rounded shimmer" role="presentation"></span>
                    <span class="w-16 h-4 rounded shimmer" role="presentation"></span>
                    <span class="w-12 h-4 rounded shimmer" role="presentation"></span>
                    <span class="w-16 h-4 rounded shimmer" role="presentation"></span>
                    <span class="w-28 h-4 rounded shimmer" role="presentation"></span>
                </div>

                <!-- Right Utility Icons -->
                <div class="flex items-center gap-5">
                    <span class="w-48 h-8 rounded-full shimmer" role="presentation"></span>
                    <span class="w-5 h-5 rounded shimmer" role="presentation"></span>
                    <span class="w-5 h-5 rounded shimmer" role="presentation"></span>
                    <span class="w-5 h-5 rounded shimmer" role="presentation"></span>
                </div>
            </div>
        </div>

        <!-- Mobile Header Shimmer -->
        <div class="flex flex-wrap gap-4 px-4 pb-4 pt-4 shadow-sm lg:hidden bg-white">
            <div class="flex w-full items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="shimmer block h-6 w-6 rounded" role="presentation"></span>
                    <span class="font-display text-2xl font-black text-[#133b63]">SOX<span class="text-[#f29a38]">N</span>SOX</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="shimmer block h-6 w-6 rounded" role="presentation"></span>
                    <span class="shimmer block h-6 w-6 rounded" role="presentation"></span>
                </div>
            </div>
        </div>
    </v-header-switcher>
</header>

{!! view_render_event('bagisto.shop.layout.header.after') !!}

@pushOnce('scripts')
    <script 
        type="text/x-template" 
        id="v-header-switcher-template"
    >
        <v-desktop-header v-if="isDesktop"></v-desktop-header>
        
        <v-mobile-header v-else></v-mobile-header>
    </script>

    <script type="module">
        app.component('v-header-switcher', {
            template: '#v-header-switcher-template',

            data() {
                return {
                    isDesktop: window.innerWidth >= 1024
                }
            },

            mounted() {
                this.media = window.matchMedia('(min-width: 1024px)');

                this.media.addEventListener('change', this.handleMedia);
            },

            beforeUnmount() {
                this.media.removeEventListener('change', this.handleMedia);
            },

            methods: {
                handleMedia(e) {
                    this.isDesktop = e.matches;
                }
            }
        });

        app.component('v-desktop-header', {
            template: '#v-desktop-header-template'
        });

        app.component('v-mobile-header', {
            template: '#v-mobile-header-template'
        });
    </script>

    <script 
        type="text/x-template" 
        id="v-desktop-header-template"
    >
        <x-shop::layouts.header.desktop />
    </script>

    <script 
        type="text/x-template" 
        id="v-mobile-header-template"
    >
        <x-shop::layouts.header.mobile />
    </script>
@endPushOnce
