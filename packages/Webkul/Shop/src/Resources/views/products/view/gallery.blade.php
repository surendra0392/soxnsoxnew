<v-product-gallery ref="gallery" class="w-full block">
    <x-shop::shimmer.products.gallery />
</v-product-gallery>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-product-gallery-template"
    >
        <div class="w-full">
            <!-- Desktop Gallery -->
            @include('shop::products.view.gallery.desktop')

            <!-- Mobile Gallery -->
            @include('shop::products.view.gallery.mobile')
            
            <!-- Gallery Images Zoomer -->
            <x-shop::image-zoomer
                ::attachments="attachments"
                ::is-image-zooming="isImageZooming"
                ::initial-index="`media_${activeIndex}`"
            />
        </div>
    </script>

    <script type="module">
        app.component('v-product-gallery', {
            template: '#v-product-gallery-template',

            data() {
                return {
                    isImageZooming: false,

                    isMediaLoading: true,

                    media: {
                        images: @json(product_image()->getGalleryImages($product)),

                        videos: @json(product_video()->getVideos($product)),
                    },

                    baseFile: {
                        type: '',

                        path: ''
                    },

                    activeIndex: 0,

                    containerOffset: 180,
                };
            },

            watch: {
                'media.images': {
                    deep: true,

                    handler(newImages, oldImages) {
                        if (this.activeIndex >= (newImages?.length || 0)) {
                            this.activeIndex = 0;
                        }

                        let selectedImage = newImages?.[this.activeIndex];

                        if (JSON.stringify(newImages) !== JSON.stringify(oldImages) && selectedImage?.large_image_url) {
                            this.baseFile.path = selectedImage.large_image_url;
                        }
                    },
                },
            },
        
            mounted() {
                if (this.media.images.length) {
                    this.baseFile.type = 'image';

                    this.baseFile.path = this.media.images[0].large_image_url;
                } else if (this.media.videos.length) {
                    this.baseFile.type = 'video';

                    this.baseFile.path = this.media.videos[0].video_url;
                }

                this.$emitter.on('configurable-variant-update-images-event', (images) => {
                    if (images && images.length) {
                        this.activeIndex = 0;
                        this.media.images = [...images];
                        this.baseFile.type = 'image';
                        this.baseFile.path = images[0].large_image_url || images[0].medium_image_url || images[0].original_image_url;

                        this.$nextTick(() => {
                            if (this.$refs.swiperContainer) {
                                this.$refs.swiperContainer.scrollLeft = 0;
                            }
                        });
                    }
                });
            },

            computed: {
                lengthOfMedia() {
                    return [...(this.media.images || []), ...(this.media.videos || [])].length;
                },

                attachments() {
                    return [...this.media.images, ...this.media.videos].map(media => ({
                        url: media.type === 'videos' ? media.video_url : media.original_image_url,
                        
                        type: media.type === 'videos' ? 'video' : 'image',
                    }));
                },
            },

            methods: {
                isActiveMedia(index) {
                    return index === this.activeIndex;
                },
                
                onMediaLoad() {
                    this.isMediaLoading = false;
                },

                scrollToIndex(index) {
                    this.$nextTick(() => {
                        const container = this.$refs.swiperContainer;
                        if (!container) return;
                        const items = container.querySelectorAll('.gallery-thumb-item');
                        if (items && items[index]) {
                            items[index].scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest',
                                inline: 'nearest',
                            });
                        }
                    });
                },

                change(media, index) {
                    this.isMediaLoading = true;

                    if (media.type == 'videos') {
                        this.baseFile.type = 'video';

                        this.baseFile.path = media.video_url;

                        this.onMediaLoad();
                    } else {
                        this.baseFile.type = 'image';

                        this.baseFile.path = media.large_image_url;
                    }

                    this.activeIndex = index;

                    this.scrollToIndex(index);
                },

                prevMedia() {
                    const list = [...(this.media.images || []), ...(this.media.videos || [])];
                    if (! list.length) {
                        return;
                    }

                    let newIndex = this.activeIndex - 1;
                    if (newIndex < 0) {
                        newIndex = list.length - 1;
                    }

                    this.change(list[newIndex], newIndex);
                },

                nextMedia() {
                    const list = [...(this.media.images || []), ...(this.media.videos || [])];
                    if (! list.length) {
                        return;
                    }

                    let newIndex = this.activeIndex + 1;
                    if (newIndex >= list.length) {
                        newIndex = 0;
                    }

                    this.change(list[newIndex], newIndex);
                },

                swipeLeft() {
                    const container = this.$refs.swiperContainer;

                    if (container) {
                        container.scrollLeft -= this.containerOffset;
                    }
                },

                swipeRight() {
                    const container = this.$refs.swiperContainer;

                    if (container) {
                        if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                            container.scrollLeft = 0;
                        } else {
                            container.scrollLeft += this.containerOffset;
                        }
                    }
                },

                swipeTop() {
                    this.swipeLeft();
                },

                swipeDown() {
                    this.swipeRight();
                },
            },
        });
    </script>
@endpushOnce
