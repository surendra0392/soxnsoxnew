<v-quick-view></v-quick-view>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-quick-view-template"
    >
        <teleport to="body">
            <div v-if="isOpen">
                <!-- Modal Overlay Backdrop -->
                <transition
                    enter-active-class="transition-opacity duration-300 ease-out"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="transition-opacity duration-200 ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        class="fixed inset-0 transition-opacity"
                        style="position: fixed; inset: 0; z-index: 9998; background-color: rgba(12, 31, 51, 0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
                        @click="close"
                    ></div>
                </transition>

                <!-- Modal Content Dialog Wrapper -->
                <transition
                    enter-active-class="transition-all duration-300 ease-out"
                    enter-from-class="opacity-0 scale-95 translate-y-4"
                    enter-to-class="opacity-100 scale-100 translate-y-0"
                    leave-active-class="transition-all duration-200 ease-in"
                    leave-from-class="opacity-100 scale-100 translate-y-0"
                    leave-to-class="opacity-0 scale-95 translate-y-4"
                >
                    <div
                        class="fixed inset-0 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
                        style="position: fixed; inset: 0; z-index: 9999;"
                        @click.self="close"
                    >
                    <!-- Modal Frame (Relative container with visible overflow so close button sits completely on top) -->
                    <div
                        class="relative w-full max-w-4xl my-auto"
                        role="dialog"
                        aria-modal="true"
                    >
                        <!-- Modal Dialog Card Body -->
                        <div class="relative z-10 w-full max-h-[88vh] overflow-y-auto rounded-3xl bg-white border border-[#e5e7eb] shadow-2xl p-6 sm:p-8">
                            <div class="flex flex-col md:flex-row gap-8" v-if="product">
                                <!-- Left: Gallery Showcase -->
                                <div class="w-full md:w-1/2 flex flex-col gap-4">
                                    <div class="relative aspect-square w-full overflow-hidden rounded-2xl bg-[#f8fafc] border border-[#e5e7eb]">
                                        <img
                                            :src="activeImage || product.base_image?.large_image_url || product.base_image?.medium_image_url"
                                            :alt="product.name"
                                            class="h-full w-full object-cover transition-all duration-300"
                                        />

                                        <!-- Badges -->
                                        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                                            <span
                                                v-if="product.discount_percent > 0"
                                                class="inline-flex items-center px-3 py-1 rounded-full bg-[#133b63] text-white text-[10px] font-bold tracking-wider uppercase shadow-sm"
                                            >
                                                @{{ product.discount_percent }}% OFF
                                            </span>
                                            <span
                                                v-if="product.is_new"
                                                class="inline-flex items-center px-3 py-1 rounded-full bg-[#f29a38] text-white text-[10px] font-bold tracking-wider uppercase shadow-sm"
                                            >
                                                New Arrival
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Thumbnail strip if multiple gallery images -->
                                    <div
                                        class="flex items-center gap-3 overflow-x-auto pb-1"
                                        v-if="(quickGalleryImages && quickGalleryImages.length > 1) || (product.gallery_images && product.gallery_images.length > 1)"
                                    >
                                        <button
                                            v-for="(img, idx) in (quickGalleryImages.length ? quickGalleryImages : product.gallery_images)"
                                            :key="idx"
                                            type="button"
                                            class="relative h-16 w-16 shrink-0 overflow-hidden rounded-xl border-2 transition-all cursor-pointer"
                                            :class="activeImage === (img.large_image_url || img.medium_image_url) ? 'border-[#2ca7a3] ring-2 ring-[#2ca7a3]/20' : 'border-slate-200 opacity-70 hover:opacity-100'"
                                            @click="activeImage = img.large_image_url || img.medium_image_url"
                                        >
                                            <img
                                                :src="img.small_image_url || img.medium_image_url"
                                                :alt="product.name"
                                                class="h-full w-full object-cover"
                                            />
                                        </button>
                                    </div>
                                </div>

                                <!-- Right: Product Information & Commerce Actions -->
                                <div class="w-full md:w-1/2 flex flex-col justify-between space-y-6">
                                    <div class="space-y-4">
                                        <!-- Eyebrow Category -->
                                        <div class="flex items-center justify-between gap-3">
                                            <span class="soxnsox-eyebrow">@{{ product.category_name || 'Bamboo Socks' }}</span>
                                            <span
                                                v-if="product.formatted_weight"
                                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-[11px] font-semibold text-[#6b7280]"
                                            >
                                                @{{ product.formatted_weight }}
                                            </span>
                                        </div>

                                        <!-- Product Title -->
                                        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#133b63] leading-snug">
                                            @{{ product.name }}
                                        </h3>

                                        <!-- Side-by-Side Pricing -->
                                        <div class="flex items-baseline gap-3 pt-1">
                                            <template v-if="activePrice">
                                                <span class="text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                                                    @{{ activePrice }}
                                                </span>
                                            </template>
                                            <template v-else-if="product.special_price">
                                                <span class="text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                                                    @{{ product.special_price }}
                                                </span>
                                                <span class="text-base text-[#6b7280] line-through font-normal">
                                                    @{{ product.regular_price }}
                                                </span>
                                                <span
                                                    v-if="product.discount_percent > 0"
                                                    class="px-2 py-0.5 rounded-full bg-[#fff4e8] text-[#f29a38] text-xs font-bold"
                                                >
                                                    Save @{{ product.discount_percent }}%
                                                </span>
                                            </template>
                                            <template v-else>
                                                <span class="text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                                                    @{{ product.formatted_price || product.regular_price || product.min_price }}
                                                </span>
                                            </template>
                                        </div>

                                        <!-- Short Description -->
                                        <p
                                            class="text-xs sm:text-sm text-[#6b7280] leading-relaxed pt-2 border-t border-slate-100"
                                            v-if="product.short_description"
                                        >
                                            @{{ product.short_description }}
                                        </p>

                                        <!-- Bamboo Trust Badges -->
                                        <div class="grid grid-cols-2 gap-2 pt-2 text-[11px] text-[#133b63] font-semibold">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-leaf text-[#2ca7a3] text-sm"></i>
                                                <span>100% Pure Bamboo</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-shield-halved text-[#f29a38] text-sm"></i>
                                                <span>Seamless Blister Shield</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-user-doctor text-[#1d5b8f] text-sm"></i>
                                                <span>Diabetic &amp; Sensitive Fit</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-truck-fast text-[#2ca7a3] text-sm"></i>
                                                <span>Free Shipping &gt; ₹499</span>
                                            </div>
                                        </div>

                                        <!-- Configurable Options Container -->
                                        <div v-if="product.type === 'configurable'" class="space-y-4 pt-3 border-t border-slate-100">
                                            <!-- Loading options state -->
                                            <div v-if="isLoadingConfig" class="flex items-center gap-2 text-xs text-[#6b7280]">
                                                <svg class="animate-spin h-3.5 w-3.5 text-[#2ca7a3]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span>Loading sock options...</span>
                                            </div>

                                            <!-- Attributes -->
                                            <div v-else-if="configurableAttributes.length" class="space-y-3">
                                                <div v-for="attribute in configurableAttributes" :key="attribute.id" class="space-y-1.5">
                                                    <div class="flex items-center justify-between text-xs font-bold text-[#133b63]">
                                                        <span class="uppercase tracking-wider">@{{ attribute.label }}</span>
                                                        <span v-if="attribute.selectedValueName" class="text-[#2ca7a3] font-semibold text-[11px]">
                                                            @{{ attribute.selectedValueName }}
                                                        </span>
                                                    </div>

                                                    <!-- Color Swatches -->
                                                    <div v-if="attribute.code === 'color' || attribute.swatch_type === 'color'" class="flex items-center gap-2 flex-wrap">
                                                        <button
                                                            v-for="option in attribute.options"
                                                            :key="option.id"
                                                            type="button"
                                                            class="relative flex h-8 w-8 cursor-pointer items-center justify-center rounded-full transition-all focus:outline-none"
                                                            :class="option.id === attribute.selectedValue ? 'ring-2 ring-offset-2 ring-[#2ca7a3] scale-110' : 'ring-1 ring-slate-200 hover:scale-105'"
                                                            :title="option.label"
                                                            @click="onSelectOption(attribute, option)"
                                                        >
                                                            <span
                                                                class="h-full w-full rounded-full border border-black/10"
                                                                :style="{ backgroundColor: option.swatch_value || '#cbd5e1' }"
                                                            ></span>
                                                        </button>
                                                    </div>

                                                    <!-- Button / Pill Options (e.g. Pack Size) -->
                                                    <div v-else class="flex items-center gap-2 flex-wrap">
                                                        <button
                                                            v-for="option in attribute.options"
                                                            :key="option.id"
                                                            type="button"
                                                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all border"
                                                            :class="option.id === attribute.selectedValue ? 'bg-[#133b63] text-white border-[#133b63] shadow-sm' : 'bg-slate-50 text-[#133b63] border-slate-200 hover:border-[#2ca7a3]'"
                                                            @click="onSelectOption(attribute, option)"
                                                        >
                                                            @{{ option.label }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Commerce Action Controls -->
                                    <div class="space-y-4 pt-4 border-t border-slate-100">
                                        <div class="flex items-center gap-4">
                                            <!-- Quantity Selector -->
                                            <div class="flex items-center rounded-xl border border-slate-200 bg-[#f5f7fa] p-1">
                                                <button
                                                    type="button"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-base font-bold text-[#133b63] hover:bg-white transition-colors disabled:opacity-30"
                                                    :disabled="quantity <= 1"
                                                    @click="quantity > 1 ? quantity-- : null"
                                                >
                                                    -
                                                </button>

                                                <span class="w-10 text-center text-sm font-bold text-[#133b63]">
                                                    @{{ quantity }}
                                                </span>

                                                <button
                                                    type="button"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-base font-bold text-[#133b63] hover:bg-white transition-colors"
                                                    @click="quantity++"
                                                >
                                                    +
                                                </button>
                                            </div>

                                            <!-- Add to Cart Button -->
                                            <button
                                                type="button"
                                                class="soxnsox-btn-primary flex-1 py-3.5 px-6 rounded-full font-bold uppercase tracking-wider text-xs shadow-md transition-all disabled:opacity-50"
                                                :disabled="! product.is_saleable || isAddingToCart"
                                                @click="addToCart()"
                                            >
                                                <span v-if="! product.is_saleable">Out of Stock</span>
                                                <span v-else-if="! isAddingToCart">Add To Cart</span>
                                                <span v-else>Adding...</span>
                                            </button>
                                        </div>

                                        <!-- View Full Details Link -->
                                        <div class="text-center pt-2">
                                            <a
                                                :href="'{{ route('shop.products.view', ':slug') }}'.replace(':slug', product.url_key)"
                                                class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-widest text-[#1d5b8f] hover:text-[#133b63] underline underline-offset-4 transition-colors"
                                            >
                                                <span>View Full Sock Details &amp; Sizing</span>
                                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Close Button: Placed on TOP (after the card body in DOM order with z-index: 9999) -->
                        <button
                            type="button"
                            class="absolute flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full shadow-2xl transition-all duration-200 hover:scale-110 hover:brightness-125 focus:outline-none cursor-pointer"
                            style="top: -14px; right: -14px; background-color: #133b63; color: #ffffff; border: 2.5px solid #ffffff; z-index: 9999; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);"
                            aria-label="Close Quick View"
                            @click="close"
                        >
                            <i class="fa-solid fa-xmark text-white text-base"></i>
                        </button>
                    </div>
                </div>
            </transition>
        </div>
    </teleport>
    </script>

    <script type="module">
        app.component('v-quick-view', {
            template: '#v-quick-view-template',

            data() {
                return {
                    isOpen: false,
                    product: null,
                    activeImage: null,
                    quickGalleryImages: [],
                    quantity: 1,
                    isAddingToCart: false,
                    config: null,
                    isLoadingConfig: false,
                    configurableAttributes: [],
                    selectedSuperAttributes: {},
                    selectedVariantId: null,
                    activePrice: null,
                };
            },

            mounted() {
                window.addEventListener('keydown', this.handleKeydown);

                this.$emitter.on('open-quick-view', (product) => {
                    this.product = product;
                    this.activeImage = product.base_image?.large_image_url || product.base_image?.medium_image_url || null;
                    this.quickGalleryImages = product.gallery_images ? [...product.gallery_images] : [];
                    this.quantity = 1;
                    this.config = null;
                    this.configurableAttributes = [];
                    this.selectedSuperAttributes = {};
                    this.selectedVariantId = null;
                    this.activePrice = null;
                    this.isOpen = true;
                    document.body.style.overflow = 'hidden';

                    if (product.type === 'configurable') {
                        this.isLoadingConfig = true;
                        this.$axios.get('{{ route("shop.api.products.configurable_config", ":id") }}'.replace(':id', product.id))
                            .then(response => {
                                if (response.data?.data) {
                                    this.config = response.data.data;
                                    this.initAttributes();
                                }
                                this.isLoadingConfig = false;
                            })
                            .catch(() => {
                                this.isLoadingConfig = false;
                            });
                    }
                });
            },

            beforeUnmount() {
                window.removeEventListener('keydown', this.handleKeydown);

                if (this.isOpen) {
                    document.body.style.overflow = '';
                }
            },

            methods: {
                handleKeydown(e) {
                    if (e.key === 'Escape' && this.isOpen) {
                        this.close();
                    }
                },

                close() {
                    this.isOpen = false;
                    this.product = null;
                    this.activeImage = null;
                    this.quickGalleryImages = [];
                    this.config = null;
                    this.configurableAttributes = [];
                    this.selectedSuperAttributes = {};
                    this.selectedVariantId = null;
                    this.activePrice = null;
                    document.body.style.overflow = '';
                },

                initAttributes() {
                    if (! this.config?.attributes) return;

                    this.configurableAttributes = this.config.attributes.map(attr => ({
                        id: attr.id,
                        code: attr.code,
                        label: attr.label,
                        swatch_type: attr.swatch_type,
                        options: attr.options || [],
                        selectedValue: null,
                        selectedValueName: null,
                    }));

                    // Automatically select first available option for each attribute
                    if (this.configurableAttributes.length > 0) {
                        this.configurableAttributes.forEach(attr => {
                            if (attr.options && attr.options.length > 0) {
                                this.onSelectOption(attr, attr.options[0]);
                            }
                        });
                    }
                },

                onSelectOption(attribute, option) {
                    attribute.selectedValue = option.id;
                    attribute.selectedValueName = option.label;
                    this.selectedSuperAttributes[attribute.id] = option.id;

                    this.matchVariant();
                },

                matchVariant() {
                    if (! this.config?.index) return;

                    let allSelected = this.configurableAttributes.length > 0 && 
                        this.configurableAttributes.every(attr => attr.selectedValue !== null);

                    if (allSelected) {
                        let matchedVariantId = null;

                        for (let [variantId, attrMap] of Object.entries(this.config.index)) {
                            let match = true;
                            for (let [attrId, optId] of Object.entries(attrMap)) {
                                if (String(this.selectedSuperAttributes[attrId]) !== String(optId)) {
                                    match = false;
                                    break;
                                }
                            }
                            if (match) {
                                matchedVariantId = variantId;
                                break;
                            }
                        }

                        if (matchedVariantId) {
                            this.selectedVariantId = matchedVariantId;

                            // 1. Update Price
                            let pInfo = this.config.variant_prices[matchedVariantId];
                            if (pInfo) {
                                this.activePrice = pInfo.final?.formatted_price || pInfo.regular?.formatted_price;
                            }

                            // 2. Update Image to Variant Image
                            let vImgs = this.config.variant_images[matchedVariantId];
                            if (vImgs && vImgs.length) {
                                this.activeImage = vImgs[0].large_image_url || vImgs[0].medium_image_url;

                                this.quickGalleryImages = [
                                    vImgs[0],
                                    ...(this.product.gallery_images || []).filter(img => img.large_image_url !== vImgs[0].large_image_url)
                                ];
                            }
                        }
                    } else {
                        this.selectedVariantId = null;
                        this.activePrice = null;
                    }
                },

                calculateSubtotal() {
                    if (! this.product) return '';
                    if (this.activePrice) return this.activePrice;
                    return this.product.special_price || this.product.regular_price || this.product.min_price || '';
                },

                addToCart() {
                    if (! this.product) return;

                    if (this.product.type === 'configurable') {
                        if (! this.selectedVariantId) {
                            this.$emitter.emit('add-flash', {
                                type: 'warning',
                                message: 'Please select all options before adding to cart.'
                            });
                            return;
                        }

                        this.isAddingToCart = true;

                        this.$axios.post('{{ route("shop.api.checkout.cart.store") }}', {
                                'quantity': this.quantity,
                                'product_id': this.product.id,
                                'selected_configurable_option': this.selectedVariantId,
                                'super_attribute': this.selectedSuperAttributes,
                            })
                            .then(response => {
                                if (response.data.message) {
                                    this.$emitter.emit('update-mini-cart', response.data.data);
                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                    this.$emitter.emit('open-mini-cart');
                                    this.close();
                                } else {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                                }
                                this.isAddingToCart = false;
                            })
                            .catch(error => {
                                this.$emitter.emit('add-flash', { type: 'error', message: error.response?.data?.message || 'Error adding to cart' });
                                if (error.response?.data?.redirect_uri) {
                                    window.location.href = error.response.data.redirect_uri;
                                }
                                this.isAddingToCart = false;
                            });
                        return;
                    }

                    // Simple Product
                    this.isAddingToCart = true;

                    this.$axios.post('{{ route("shop.api.checkout.cart.store") }}', {
                            'quantity': this.quantity,
                            'product_id': this.product.id,
                        })
                        .then(response => {
                            if (response.data.message) {
                                this.$emitter.emit('update-mini-cart', response.data.data);
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                this.$emitter.emit('open-mini-cart');
                                this.close();
                            } else {
                                this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                            }
                            this.isAddingToCart = false;
                        })
                        .catch(error => {
                            this.$emitter.emit('add-flash', { type: 'error', message: error.response?.data?.message || 'Error adding to cart' });
                            if (error.response?.data?.redirect_uri) {
                                window.location.href = error.response.data.redirect_uri;
                            }
                            this.isAddingToCart = false;
                        });
                },
            }
        });
    </script>
@endpushOnce
