<!-- For large screens (desktop) -->
<div class="sticky top-28 flex flex-col h-max gap-4 max-lg:hidden w-full">
    <!-- Main Product Stage Display -->
    <div class="w-full">
        <!-- Shimmer Placeholder -->
        <div
            class="aspect-square w-full rounded-2xl bg-zinc-100 shimmer border border-soxnsox-border/70"
            v-show="isMediaLoading"
        ></div>

        <!-- Actual Main Media Frame -->
        <div
            class="relative aspect-square w-full rounded-2xl bg-[#f8fafc] border border-soxnsox-border/80 overflow-hidden shadow-soxnsox-subtle p-3 flex items-center justify-center group"
            v-show="! isMediaLoading"
        >
            <!-- Bamboo Badge Overlay -->
            <div class="absolute top-4 left-4 z-10 pointer-events-none">
                <span class="soxnsox-badge-bamboo text-[10px] shadow-sm">
                    100% Pure Bamboo
                </span>
            </div>

            <!-- Prev Image Floating Button on Main Stage -->
            <button
                type="button"
                class="absolute left-3.5 top-1/2 -translate-y-1/2 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-white/95 text-soxnsox-charcoal shadow-md border border-soxnsox-border/50 hover:bg-white hover:text-soxnsox-teal hover:border-soxnsox-teal hover:scale-110 active:scale-95 transition-all duration-200 opacity-0 group-hover:opacity-100 cursor-pointer focus:opacity-100"
                aria-label="@lang('shop::app.components.products.carousel.previous')"
                @click.stop="prevMedia"
                v-show="lengthOfMedia > 1"
            >
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>

            <!-- Next Image Floating Button on Main Stage -->
            <button
                type="button"
                class="absolute right-3.5 top-1/2 -translate-y-1/2 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-white/95 text-soxnsox-charcoal shadow-md border border-soxnsox-border/50 hover:bg-white hover:text-soxnsox-teal hover:border-soxnsox-teal hover:scale-110 active:scale-95 transition-all duration-200 opacity-0 group-hover:opacity-100 cursor-pointer focus:opacity-100"
                aria-label="@lang('shop::app.components.products.carousel.next')"
                @click.stop="nextMedia"
                v-show="lengthOfMedia > 1"
            >
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <!-- Zoom Hint Overlay Button -->
            <button
                type="button"
                class="absolute bottom-4 right-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-soxnsox-charcoal shadow-sm hover:bg-white hover:text-soxnsox-teal transition-all duration-200 opacity-80 group-hover:opacity-100 cursor-pointer"
                aria-label="Zoom image"
                @click="isImageZooming = !isImageZooming"
            >
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </button>

            <!-- Main Image -->
            <img
                class="w-full h-full object-cover rounded-xl cursor-zoom-in transition-transform duration-500 ease-out group-hover:scale-[1.02]"
                :src="baseFile.path"
                v-if="baseFile.type == 'image'"
                alt="{{ $product->name }}"
                width="660"
                height="660"
                tabindex="0"
                @click="isImageZooming = !isImageZooming"
                @load="onMediaLoad()"
                fetchpriority="high"
            />

            <!-- Main Video -->
            <div
                class="w-full h-full rounded-xl overflow-hidden"
                tabindex="0"
                v-if="baseFile.type == 'video'"
            >
                <video
                    controls
                    class="w-full h-full object-cover rounded-xl"
                    alt="{{ $product->name }}"
                    @click="isImageZooming = !isImageZooming"
                    @loadeddata="onMediaLoad()"
                    :key="baseFile.path"
                >
                    <source
                        :src="baseFile.path"
                        type="video/mp4"
                    />
                </video>
            </div>
        </div>
    </div>

    <!-- Product Image and Videos Thumbnails Slider (Only if multiple media items exist) -->
    <div 
        class="relative flex items-center justify-center w-full gap-2.5 pt-1"
        v-if="lengthOfMedia > 1"
    >
        <!-- Arrow Left -->
        <button
            type="button"
            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white border border-soxnsox-border/90 text-soxnsox-charcoal shadow-sm hover:text-soxnsox-teal hover:border-soxnsox-teal hover:bg-slate-50 hover:scale-105 active:scale-95 transition-all duration-200 focus:outline-none cursor-pointer"
            aria-label="@lang('shop::app.components.products.carousel.previous')"
            @click="prevMedia"
            v-show="lengthOfMedia > 1"
        >
            <i class="fa-solid fa-chevron-left text-xs"></i>
        </button>

        <!-- Swiper Container -->
        <div
            ref="swiperContainer"
            class="flex overflow-x-auto scroll-smooth scrollbar-hide py-1.5 px-1 max-w-full min-w-0"
            style="scrollbar-width: none;"
        >
            <div class="flex items-center gap-3 mx-auto min-w-max">
                <template v-for="(media, index) in [...media.images, ...media.videos]">
                    <div
                        v-if="media.type == 'videos'"
                        :class="`gallery-thumb-item relative aspect-square w-[80px] h-[80px] shrink-0 cursor-pointer rounded-xl overflow-hidden border transition-all duration-200 ${isActiveMedia(index) ? 'border-2 border-soxnsox-teal ring-2 ring-soxnsox-teal/20 shadow-sm scale-105' : 'border-soxnsox-border/80 hover:border-soxnsox-teal/50 opacity-80 hover:opacity-100'}`"
                        @click="change(media, index)"
                        tabindex="0"
                    >
                        <video
                            class="w-full h-full object-cover"
                            alt="{{ $product->name }}"
                        >
                            <source
                                :src="media.video_url"
                                type="video/mp4"
                            />
                        </video>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 pointer-events-none">
                            <i class="fa-solid fa-play text-white text-xs"></i>
                        </div>
                    </div>

                    <div
                        v-else
                        :class="`gallery-thumb-item relative aspect-square w-[80px] h-[80px] shrink-0 cursor-pointer rounded-xl overflow-hidden border bg-[#f8fafc] transition-all duration-200 ${isActiveMedia(index) ? 'border-2 border-soxnsox-teal ring-2 ring-soxnsox-teal/20 shadow-sm scale-105' : 'border-soxnsox-border/80 hover:border-soxnsox-teal/50 opacity-80 hover:opacity-100'}`"
                        tabindex="0"
                        @click="change(media, index)"
                    >
                        <img
                            class="w-full h-full object-cover"
                            :src="media.small_image_url"
                            alt="{{ $product->name }}"
                            width="80"
                            height="80"
                            loading="lazy"
                        />
                    </div>
                </template>
            </div>
        </div>

        <!-- Arrow Right -->
        <button
            type="button"
            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white border border-soxnsox-border/90 text-soxnsox-charcoal shadow-sm hover:text-soxnsox-teal hover:border-soxnsox-teal hover:bg-slate-50 hover:scale-105 active:scale-95 transition-all duration-200 focus:outline-none cursor-pointer"
            aria-label="@lang('shop::app.components.products.carousel.next')"
            @click="nextMedia"
            v-show="lengthOfMedia > 1"
        >
            <i class="fa-solid fa-chevron-right text-xs"></i>
        </button>
    </div>
</div>

