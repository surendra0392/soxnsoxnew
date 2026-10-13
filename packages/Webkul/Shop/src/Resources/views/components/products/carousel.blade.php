<v-products-carousel
    src="{{ $src }}"
    title="{{ $title }}"
    navigation-link="{{ $navigationLink ?? '' }}"
>
    <x-shop::shimmer.products.carousel :navigation-link="$navigationLink ?? false" />
</v-products-carousel>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-products-carousel-template"
    >
        <div
            class="site-container py-6"
            v-if="! isLoading && products.length"
        >
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-[#133b63]">
                        @{{ title }}
                    </h2>
                    <div class="soxnsox-decorative-line mt-2"></div>
                </div>

                <div class="flex items-center gap-3">
                    <a
                        :href="navigationLink"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider text-[#2ca7a3] bg-teal-50 border border-[#2ca7a3]/30 hover:bg-[#2ca7a3] hover:text-white transition-all shadow-sm"
                        v-if="navigationLink"
                    >
                        <span>@lang('shop::app.components.products.carousel.view-all')</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>

                    <div
                        class="flex items-center gap-2"
                        v-if="products.length > 1"
                    >
                        <button
                            type="button"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-soxnsox-border/90 bg-white text-soxnsox-navy shadow-sm hover:border-soxnsox-teal hover:text-soxnsox-teal hover:bg-slate-50 hover:shadow-md hover:scale-105 active:scale-95 transition-all duration-200 focus:outline-none cursor-pointer"
                            role="button"
                            aria-label="@lang('shop::app.components.products.carousel.previous')"
                            tabindex="0"
                            @click="swipeLeft"
                        >
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>

                        <button
                            type="button"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-soxnsox-border/90 bg-white text-soxnsox-navy shadow-sm hover:border-soxnsox-teal hover:text-soxnsox-teal hover:bg-slate-50 hover:shadow-md hover:scale-105 active:scale-95 transition-all duration-200 focus:outline-none cursor-pointer"
                            role="button"
                            aria-label="@lang('shop::app.components.products.carousel.next')"
                            tabindex="0"
                            @click="swipeRight"
                        >
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div
                ref="swiperContainer"
                class="flex gap-8 pb-2.5 [&>*]:flex-[0] mt-10 overflow-auto scroll-smooth scrollbar-hide max-md:gap-7 max-md:mt-5 max-sm:gap-4 max-md:pb-0 max-md:whitespace-nowrap"
            >
                <x-shop::products.card
                    class="min-w-[291px] max-md:h-fit max-md:min-w-56 max-sm:min-w-[192px]"
                    v-for="product in products"
                />
            </div>

            <a
                :href="navigationLink"
                class="secondary-button mx-auto mt-5 block w-max rounded-full px-11 py-3 text-center text-base max-lg:mt-0 max-lg:hidden max-lg:py-3.5"
                :aria-label="title"
                v-if="navigationLink"
            >
                @lang('shop::app.components.products.carousel.view-all')
            </a>
        </div>

        <!-- Product Card Listing -->
        <template v-if="isLoading">
            <x-shop::shimmer.products.carousel :navigation-link="$navigationLink ?? false" />
        </template>
    </script>

    <script type="module">
        app.component('v-products-carousel', {
            template: '#v-products-carousel-template',

            props: [
                'src',
                'title',
                'navigationLink',
            ],

            data() {
                return {
                    isLoading: true,

                    products: [],

                    offset: 323,

                    isScreenMax2xl: window.innerWidth <= 1440,
                };
            },

            mounted() {
                this.getProducts();
            },

            created() {
                window.addEventListener('resize', this.updateScreenSize);
            },

            beforeDestroy() {
                window.removeEventListener('resize', this.updateScreenSize);
            },

            methods: {
                getProducts() {
                    this.$axios.get(this.src)
                        .then(response => {
                            this.isLoading = false;

                            this.products = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                updateScreenSize() {
                    this.isScreenMax2xl = window.innerWidth <= 1440;
                },

                swipeLeft() {
                    const container = this.$refs.swiperContainer;
                    if (! container) return;

                    if (container.scrollLeft <= 10) {
                        container.scrollLeft = container.scrollWidth - container.clientWidth;
                    } else {
                        container.scrollLeft -= this.offset;
                    }
                },

                swipeRight() {
                    const container = this.$refs.swiperContainer;
                    if (! container) return;

                    // Check if scroll reaches the end
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 15) {
                        // Reset scroll to the beginning
                        container.scrollLeft = 0;
                    } else {
                        // Scroll to the right
                        container.scrollLeft += this.offset;
                    }
                },
            },
        });
    </script>
@endPushOnce
