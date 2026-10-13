@props([
    'code' => 'soxnsox-homepage-hero',
])

@inject('heroSliderRepository', 'Webkul\Theme\Repositories\HeroSliderRepository')

@php
    $slider = $heroSliderRepository->findOneByField('code', $code);
    if (! $slider || ! $slider->status) {
        $slider = $heroSliderRepository->findOneByField('code', 'homepage-hero');
    }
    
    $activeSlides = $slider && $slider->status 
        ? $slider->slides()->where('status', 1)->with('layers')->orderBy('sort_order', 'asc')->get() 
        : collect();
        
    $sliderDuration = (int) ($slider->settings['duration'] ?? 6000);
    $sliderAutoplay = (bool) ($slider->settings['autoplay'] ?? true);

    $slidesJson = $activeSlides->map(function ($slide) use ($sliderDuration) {
        $desktopMedia = $slide->desktop_media;
        $mobileMedia = $slide->mobile_media ?: $desktopMedia;
        
        $desktopUrl = $desktopMedia ? (str_starts_with($desktopMedia, 'http') || str_starts_with($desktopMedia, '/storage/') ? $desktopMedia : Storage::url($desktopMedia)) : '';
        $mobileUrl = $mobileMedia ? (str_starts_with($mobileMedia, 'http') || str_starts_with($mobileMedia, '/storage/') ? $mobileMedia : Storage::url($mobileMedia)) : $desktopUrl;
        $videoUrl = $slide->video_url ? (str_starts_with($slide->video_url, 'http') || str_starts_with($slide->video_url, '/storage/') ? $slide->video_url : Storage::url($slide->video_url)) : '';

        return [
            'id'            => $slide->id,
            'name'          => $slide->name,
            'media_type'    => $slide->media_type,
            'desktop_media' => $desktopUrl,
            'mobile_media'  => $mobileUrl,
            'video_url'     => $videoUrl,
            'duration'      => $slide->duration ?: $sliderDuration,
            'layers'        => $slide->layers->map(function ($layer) {
                return [
                    'id'               => $layer->id,
                    'type'             => $layer->type,
                    'name'             => $layer->name,
                    'content'          => $layer->content,
                    'desktop_settings' => $layer->desktop_settings ?: [],
                    'tablet_settings'  => $layer->tablet_settings ?: [],
                    'mobile_settings'  => $layer->mobile_settings ?: [],
                    'settings'         => $layer->settings ?: [],
                ];
            })->toArray(),
        ];
    })->values()->toArray();
    
    $firstSlide = $activeSlides->first();
@endphp

@if ($activeSlides->count() > 0)
    <v-hero-slider
        slider-id="{{ $slider->id }}"
        :autoplay="{{ $sliderAutoplay ? 'true' : 'false' }}"
        :delay="{{ $sliderDuration }}"
    >
        {{-- SSR Initial State: Immediate, high-contrast paint before Vue hydration --}}
        <section class="soxnsox-hero-slider relative w-full h-[600px] sm:h-[650px] md:h-[700px] lg:h-[760px] xl:h-[800px] flex items-center overflow-hidden bg-[#f8fafc] border-b border-[#e5e7eb]" aria-label="Hero Slider">
            @if ($firstSlide)
                @php
                    $firstDesk = $firstSlide->desktop_media ? (str_starts_with($firstSlide->desktop_media, 'http') || str_starts_with($firstSlide->desktop_media, '/storage/') ? $firstSlide->desktop_media : Storage::url($firstSlide->desktop_media)) : '';
                    $firstMob = $firstSlide->mobile_media ? (str_starts_with($firstSlide->mobile_media, 'http') || str_starts_with($firstSlide->mobile_media, '/storage/') ? $firstSlide->mobile_media : Storage::url($firstSlide->mobile_media)) : $firstDesk;
                @endphp
                <div class="absolute inset-0 w-full h-full">
                    @if ($firstDesk)
                        <picture class="absolute inset-0 w-full h-full">
                            @if ($firstMob && $firstMob !== $firstDesk)
                                <source media="(max-width: 767px)" srcset="{{ $firstMob }}">
                            @endif
                            <img 
                                src="{{ $firstDesk }}" 
                                alt="{{ $firstSlide->name }}"
                                class="w-full h-full object-cover object-right md:object-center"
                                fetchpriority="high"
                                loading="eager"
                            >
                        </picture>
                    @endif

                    <!-- Soft Ambient Scrim -->
                    <div class="absolute inset-0 bg-gradient-to-r from-[#f8fafc]/98 via-[#f8fafc]/85 to-transparent md:w-[65%] pointer-events-none"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#f8fafc]/95 via-[#f8fafc]/80 to-transparent md:hidden pointer-events-none"></div>

                    <!-- Editorial Content Column -->
                    <div class="site-container relative w-full h-full flex items-center">
                        <div class="w-full max-w-2xl py-8 sm:py-10 md:py-12 space-y-4 lg:space-y-5 z-20 pb-20">
                            @foreach ($firstSlide->layers as $layer)
                                @if ($layer->type === 'heading')
                                    <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-[#133b63] leading-[1.1] text-balance">
                                        {!! $layer->content !!}
                                    </h1>
                                @elseif ($layer->type === 'button')
                                    <div class="pt-1">
                                        {!! $layer->content !!}
                                    </div>
                                @else
                                    <div>
                                        {!! $layer->content !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Bottom Progress Line Controls (SSR Initial View) -->
                    @if ($activeSlides->count() > 1)
                        <div class="absolute bottom-5 sm:bottom-6 md:bottom-8 left-0 w-full z-30 pointer-events-auto">
                            <div class="site-container flex items-center gap-4 sm:gap-6">
                                @foreach ($activeSlides as $idx => $s)
                                    <div class="flex items-center gap-2.5 py-1 cursor-pointer">
                                        <span class="text-xs sm:text-sm font-sans font-bold tracking-widest {{ $idx === 0 ? 'text-soxnsox-teal' : 'text-soxnsox-charcoal/40' }}">
                                            0{{ $idx + 1 }}
                                        </span>
                                        <div class="h-[4px] sm:h-[5px] w-14 sm:w-20 md:w-28 rounded-full bg-[#133b63]/20 overflow-hidden relative">
                                            <div class="h-full bg-[#1d5b8f] rounded-full {{ $idx === 0 ? 'w-1/3' : 'w-0' }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </section>
    </v-hero-slider>

    @pushOnce('scripts')
        <script>
            window.__soxnsoxHeroSlides = {!! json_encode($slidesJson, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!};
        </script>

        <script type="text/x-template" id="v-hero-slider-template">
            <section 
                class="soxnsox-hero-slider relative w-full h-[600px] sm:h-[650px] md:h-[700px] lg:h-[760px] xl:h-[800px] flex items-center overflow-hidden group select-none bg-[#f8fafc] border-b border-[#e5e7eb]"
                @mouseenter="pauseProgress"
                @mouseleave="resumeProgress"
                @touchstart="handleTouchStart"
                @touchmove="handleTouchMove"
                @touchend="handleTouchEnd"
                role="region"
                aria-roledescription="carousel"
                aria-label="Hero Slider"
            >
                <!-- Slides Container -->
                <div class="relative w-full h-full flex items-center">
                    <div 
                        v-for="(slide, index) in slides" 
                        :key="slide.id || index"
                        class="absolute inset-0 w-full h-full flex items-center transition-opacity duration-1000 ease-in-out will-change-transform"
                        :class="currentSlide === index ? 'opacity-100 z-10 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none'"
                        role="group"
                        :aria-label="(index + 1) + ' of ' + slides.length"
                    >
                        <!-- Slide Media (Image or Video Background) -->
                        <template v-if="slide.media_type === 'video' && slide.video_url">
                            <video 
                                class="absolute inset-0 w-full h-full object-cover object-center"
                                :src="slide.video_url"
                                :poster="slide.desktop_media"
                                autoplay
                                loop
                                muted
                                playsinline
                            ></video>
                        </template>
                        <template v-else-if="slide.desktop_media">
                            <picture class="absolute inset-0 w-full h-full">
                                <source v-if="slide.mobile_media && slide.mobile_media !== slide.desktop_media" media="(max-width: 767px)" :srcset="slide.mobile_media">
                                <img 
                                    :src="slide.desktop_media" 
                                    :alt="slide.name || 'Hero slide'"
                                    class="w-full h-full object-cover object-right md:object-center"
                                    :loading="index === 0 ? 'eager' : 'lazy'"
                                >
                            </picture>
                        </template>

                        <!-- Clean Ambient Scrim for High-Contrast Readability -->
                        <div class="absolute inset-0 bg-gradient-to-r from-[#f5f7fa]/98 via-[#f5f7fa]/85 to-transparent md:w-[65%] pointer-events-none"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#f5f7fa]/95 via-[#f5f7fa]/80 to-transparent md:hidden pointer-events-none"></div>

                        <!-- Editorial Content Column -->
                        <div class="site-container relative w-full h-full flex items-center">
                            <div class="w-full max-w-2xl py-8 sm:py-10 md:py-12 space-y-4 lg:space-y-5 z-20 pb-20">
                                <div 
                                    v-for="(layer, lIdx) in slide.layers" 
                                    :key="layer.id || lIdx"
                                    :class="layer.settings?.classes || ''"
                                >
                                    <template v-if="layer.type === 'heading'">
                                        <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-[#133b63] leading-[1.1] text-balance" v-html="layer.content"></h2>
                                    </template>
                                    <template v-else-if="layer.type === 'button'">
                                        <div class="pt-1" v-html="layer.content"></div>
                                    </template>
                                    <template v-else>
                                        <div v-html="layer.content"></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Segmented Line Progress Controls -->
                <div v-if="slides.length > 1" class="absolute bottom-5 sm:bottom-6 md:bottom-8 left-0 w-full z-30 pointer-events-auto">
                    <div class="site-container flex items-center gap-4 sm:gap-6">
                        <button
                            v-for="(slide, index) in slides"
                            :key="'line-ctrl-' + index"
                            @click="goTo(index)"
                            class="group flex items-center gap-2.5 sm:gap-3 py-1.5 cursor-pointer focus:outline-none"
                            :aria-label="'Go to slide ' + (index + 1) + ': ' + (slide.name || '')"
                        >
                            <!-- Slide Number -->
                            <span 
                                class="text-xs sm:text-sm font-sans font-bold tracking-widest transition-colors duration-300"
                                :class="currentSlide === index ? 'text-[#1d5b8f] font-extrabold' : 'text-soxnsox-charcoal/50 group-hover:text-soxnsox-charcoal'"
                            >
                                0@{{ index + 1 }}
                            </span>

                            <!-- Progress Line Bar -->
                            <div class="h-[4px] sm:h-[5px] w-14 sm:w-20 md:w-28 rounded-full bg-soxnsox-charcoal/20 group-hover:bg-soxnsox-charcoal/35 overflow-hidden relative transition-colors duration-300">
                                <div 
                                    class="h-full bg-[#f29a38] rounded-full will-change-[width]"
                                    :style="getProgressBarStyle(index)"
                                ></div>
                            </div>
                        </button>
                    </div>
                </div>
            </section>
        </script>

        <script type="module">
            app.component('v-hero-slider', {
                template: '#v-hero-slider-template',
                props: {
                    autoplay: {
                        type: Boolean,
                        default: true
                    },
                    delay: {
                        type: Number,
                        default: 6000
                    }
                },
                data() {
                    return {
                        slides: window.__soxnsoxHeroSlides || [],
                        currentSlide: 0,
                        isPlaying: this.autoplay,
                        progress: 0,
                        startTime: null,
                        pausedTime: null,
                        isPaused: false,
                        animationFrameId: null,
                        touchStartX: 0,
                        touchEndX: 0,
                    };
                },
                computed: {
                    currentDuration() {
                        const slide = this.slides[this.currentSlide];
                        return (slide && slide.duration) ? slide.duration : this.delay;
                    }
                },
                mounted() {
                    if (this.slides.length > 1) {
                        this.startProgress();
                    }

                    // Respect prefers-reduced-motion
                    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                        this.isPaused = true;
                    }

                    window.addEventListener('keydown', this.handleKeyDown);
                },
                beforeUnmount() {
                    this.cancelProgress();
                    window.removeEventListener('keydown', this.handleKeyDown);
                },
                methods: {
                    startProgress() {
                        this.cancelProgress();
                        this.progress = 0;
                        this.startTime = performance.now();
                        this.isPaused = false;
                        
                        if (! this.autoplay) return;

                        const step = (now) => {
                            if (this.isPaused) {
                                this.animationFrameId = requestAnimationFrame(step);
                                return;
                            }

                            const elapsed = now - this.startTime;
                            const duration = this.currentDuration;
                            this.progress = Math.min(100, (elapsed / duration) * 100);

                            if (elapsed >= duration) {
                                this.next();
                            } else {
                                this.animationFrameId = requestAnimationFrame(step);
                            }
                        };

                        this.animationFrameId = requestAnimationFrame(step);
                    },
                    pauseProgress() {
                        if (! this.autoplay || this.slides.length <= 1) return;
                        this.isPaused = true;
                        this.pausedTime = performance.now();
                    },
                    resumeProgress() {
                        if (! this.autoplay || this.slides.length <= 1) return;
                        if (this.isPaused && this.pausedTime && this.startTime) {
                            const pauseDuration = performance.now() - this.pausedTime;
                            this.startTime += pauseDuration;
                        }
                        this.isPaused = false;
                    },
                    cancelProgress() {
                        if (this.animationFrameId) {
                            cancelAnimationFrame(this.animationFrameId);
                            this.animationFrameId = null;
                        }
                    },
                    next() {
                        if (this.slides.length <= 1) return;
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                        this.startProgress();
                    },
                    prev() {
                        if (this.slides.length <= 1) return;
                        this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                        this.startProgress();
                    },
                    goTo(index) {
                        if (this.currentSlide === index) return;
                        this.currentSlide = index;
                        this.startProgress();
                    },
                    getProgressBarStyle(index) {
                        if (index < this.currentSlide) {
                            return { width: '100%' };
                        } else if (index === this.currentSlide) {
                            return { width: this.progress + '%' };
                        } else {
                            return { width: '0%' };
                        }
                    },
                    handleKeyDown(e) {
                        if (e.key === 'ArrowRight') {
                            this.next();
                        } else if (e.key === 'ArrowLeft') {
                            this.prev();
                        }
                    },
                    handleTouchStart(e) {
                        if (e.touches && e.touches[0]) {
                            this.touchStartX = e.touches[0].clientX;
                        }
                    },
                    handleTouchMove(e) {
                        if (e.touches && e.touches[0]) {
                            this.touchEndX = e.touches[0].clientX;
                        }
                    },
                    handleTouchEnd() {
                        const threshold = 40;
                        if (this.touchEndX !== 0 && this.touchEndX < this.touchStartX - threshold) {
                            this.next();
                        } else if (this.touchEndX !== 0 && this.touchEndX > this.touchStartX + threshold) {
                            this.prev();
                        }
                        this.touchStartX = 0;
                        this.touchEndX = 0;
                    }
                }
            });
        </script>
    @endPushOnce
@endif
