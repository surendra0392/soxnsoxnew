<v-gallery-zoomer {{ $attributes }}></v-gallery-zoomer>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-gallery-zoomer-template"
    >
        <teleport to="body">
            <div v-if="isOpen">
                <!-- Modal Overlay Backdrop with Blur -->
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
                        @click="toggle"
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
                        @click.self="toggle"
                    >
                        <!-- Modal Frame with Visible Overflow for Close Button -->
                        <div
                            class="relative w-full max-w-3xl my-auto"
                            role="dialog"
                            aria-modal="true"
                        >
                            <!-- Modal Card Body -->
                            <div class="relative z-10 w-full rounded-3xl bg-white border border-[#e5e7eb] shadow-2xl p-5 sm:p-7 flex flex-col items-center gap-4">
                                <!-- Main Image Stage -->
                                <div
                                    ref="mediaContainer"
                                    class="relative w-full h-[60vh] sm:h-[68vh] flex items-center justify-center overflow-hidden rounded-2xl bg-[#f8fafc]"
                                >
                                    <!-- Left Navigation Arrow -->
                                    <button
                                        type="button"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 z-20 flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full bg-white/90 border border-[#e5e7eb] text-[#133b63] hover:bg-[#1d5b8f] hover:text-white transition-all shadow-md cursor-pointer"
                                        v-if="attachments.length >= 2"
                                        @click="navigate(currentIndex -= 1)"
                                        aria-label="Previous image"
                                    >
                                        <i class="fa-solid fa-chevron-left text-base"></i>
                                    </button>

                                    <!-- Right Navigation Arrow -->
                                    <button
                                        type="button"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 z-20 flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full bg-white/90 border border-[#e5e7eb] text-[#133b63] hover:bg-[#1d5b8f] hover:text-white transition-all shadow-md cursor-pointer"
                                        v-if="attachments.length >= 2"
                                        @click="navigate(currentIndex += 1)"
                                        aria-label="Next image"
                                    >
                                        <i class="fa-solid fa-chevron-right text-base"></i>
                                    </button>

                                    <!-- Slides Container -->
                                    <div
                                        v-for="(attachment, index) in attachments"
                                        class="h-full w-full flex items-center justify-center"
                                        ref="slides"
                                        :key="index"
                                    >
                                        <video
                                            class="max-h-full max-w-full object-contain rounded-xl"
                                            controls
                                            v-if="attachment.type == 'video'"
                                        >
                                            <source :src="attachment.url" type="video/mp4">
                                            <source :src="attachment.url" type="video/ogg">
                                            Your browser does not support HTML video.
                                        </video>

                                        <template v-if="attachment.type === 'image'">
                                            <img
                                                :src="attachment.url"
                                                alt="Enlarged sock view"
                                                class="max-h-full max-w-full object-contain select-none transition-transform duration-200 ease-out"
                                                :class="{
                                                    'cursor-zoom-in': ! isZooming,
                                                    'cursor-grab': ! isDragging && isZooming,
                                                    'cursor-grabbing': isDragging && isZooming,
                                                }"
                                                :style="{transform: `translate(${translateX}px, ${translateY}px)`}"
                                                @click.stop="handleClick"
                                                @mousedown.prevent="handleMouseDown"
                                                @mousemove.prevent="handleMouseMove"
                                                @mouseleave.prevent="resetImagePosition"
                                                @mouseup.prevent="resetImagePosition"
                                                @mousewheel="handleMouseWheel"
                                            />
                                        </template>
                                    </div>
                                </div>

                                <!-- Thumbnails Strip (if multiple images) -->
                                <div
                                    class="flex items-center justify-center gap-2.5 overflow-x-auto w-full pt-1"
                                    v-if="attachments.length > 1"
                                >
                                    <template v-for="(attachment, index) in attachments">
                                        <button
                                            type="button"
                                            class="relative h-14 w-14 shrink-0 overflow-hidden rounded-xl border-2 transition-all cursor-pointer"
                                            :class="currentIndex === index + 1 ? 'border-[#1d5b8f] ring-2 ring-[#1d5b8f]/20' : 'border-[#e5e7eb] opacity-60 hover:opacity-100'"
                                            @click="navigate(currentIndex = index + 1)"
                                            :key="index"
                                        >
                                            <img
                                                :src="attachment.url"
                                                alt="Sock thumbnail"
                                                class="h-full w-full object-cover"
                                                v-if="attachment.type === 'image'"
                                            />
                                            <video
                                                :src="attachment.url"
                                                class="h-full w-full object-cover"
                                                v-if="attachment.type === 'video'"
                                            />
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Close Button (Top-Right of modal card, exactly matching Quick View modal style) -->
                            <button
                                type="button"
                                class="absolute flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full shadow-2xl transition-all duration-200 hover:scale-110 focus:outline-none cursor-pointer"
                                style="top: -14px; right: -14px; background-color: #133b63; color: #ffffff; border: 2.5px solid #ffffff; z-index: 9999; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);"
                                aria-label="Close zoomed view"
                                @click="toggle"
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
        app.component('v-gallery-zoomer', {
            template: '#v-gallery-zoomer-template',

            props: {
                attachments: {
                    type: Object,

                    required: true,

                    default: () => [],
                },

                isImageZooming: {
                    type: Boolean,

                    default: false,
                },

                initialIndex: {
                    type: String,
                    
                    default: 0,
                },
            },

            watch: {
                isImageZooming(newVal, oldVal) {  
                    this.currentIndex = parseInt(this.initialIndex.split('_').pop()) + 1;

                    this.isOpen = true;

                    this.$nextTick(() => {
                        this.navigate(this.currentIndex);
                    });

                    document.body.style.overflow = 'hidden';
                },
            },
        
            data() {
                return {
                    isOpen: false,

                    isDragging: false,

                    isZooming: false,

                    currentIndex: 1,

                    startDragX: 0,

                    startDragY: 0,

                    translateX: 0,

                    translateY: 0,

                    isMouseMoveTriggered: false,

                    isMouseDownTriggered: false,
                };
            },

            mounted() {
                window.addEventListener('keydown', this.handleKeydown);
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

                toggle() {
                    this.isOpen = ! this.isOpen;

                    document.body.style.overflow = this.isOpen ? 'hidden' : '';

                    this.$emit('toggle', { isActive: this.isOpen });
                },

                close() {
                    this.isOpen = false;

                    document.body.style.overflow = '';
                },

                navigate(index) {
                    if (index > this.attachments.length) {
                        this.currentIndex = 1;
                    }

                    if (index < 1) {
                        this.currentIndex = this.attachments.length;
                    }

                    let slides = this.$refs.slides;

                    if (slides && slides.length) {
                        for (let i = 0; i < slides.length; i++) {
                            if (i == this.currentIndex - 1) {
                                slides[i].style.display = 'flex';
                            } else {
                                slides[i].style.display = 'none';
                            }
                        }
                    }

                    this.isZooming = false;

                    this.resetDrag();
                },

                handleClick(event) {
                    if (
                        this.isMouseMoveTriggered
                        && ! this.isMouseDownTriggered
                    ) {
                        return;
                    }

                    this.resetDrag();

                    this.isZooming = ! this.isZooming;
                },

                handleMouseDown(event) {
                    this.isMouseDownTriggered = true;

                    this.isDragging = true;

                    this.startDragX = event.clientX;

                    this.startDragY = event.clientY;
                },

                handleMouseMove(event) {
                    this.isMouseMoveTriggered = true;
                    
                    this.isMouseDownTriggered = false;

                    if (! this.isDragging) {
                        return;
                    }

                    const deltaX = event.clientX - this.startDragX;
                    
                    const deltaY = event.clientY - this.startDragY;
                    
                    const newTranslateY = this.translateY + deltaY;

                    const remainingHeight = this.$refs.mediaContainer.clientHeight - this.$refs.mediaContainer.clientHeight;

                    const maxTranslateY = Math.min(0, window.innerHeight - (event.srcElement.height + remainingHeight));

                    const clampedTranslateY = Math.max(maxTranslateY, Math.min(newTranslateY, 0));

                    this.translateY = clampedTranslateY;
                    
                    this.startDragY = event.clientY;
                    
                    this.startDragX = event.clientX;

                    this.translateX += deltaX;
                },

                handleMouseWheel(event) {
                    const deltaY = event.clientY - this.startDragY;

                    let newTranslateY = this.translateY - event.deltaY / Math.abs(event.deltaY) * 100;
                    
                    const remainingHeight = this.$refs.mediaContainer.clientHeight - this.$refs.mediaContainer.clientHeight;

                    const maxTranslateY = Math.min(0, window.innerHeight - (event.srcElement.height + remainingHeight));

                    this.translateY = Math.max(maxTranslateY, Math.min(newTranslateY, 0));
                },

                resetImagePosition() {
                    this.isDragging = false;

                    this.translateX  = 0;

                    this.startDragX = 0;
                },

                resetDrag() {
                    this.isDragging = false;

                    this.startDragX = 0;

                    this.startDragY = 0;

                    this.translateX = 0;

                    this.translateY = 0;
                },
            },
        });
    </script>
@endPushOnce