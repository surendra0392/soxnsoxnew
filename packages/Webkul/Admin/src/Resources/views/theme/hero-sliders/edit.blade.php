<x-admin::layouts>
    <x-slot:title>
        Edit Hero Slider
    </x-slot>

    <!-- Input Form -->
    <x-admin::form
        :action="route('admin.cms.hero_sliders.update', $heroSlider->id)"
        enctype="multipart/form-data"
        method="PUT"
    >
        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 font-bold">
                Edit Hero Slider: {{ $heroSlider->name }}
            </p>

            <div class="flex gap-x-2.5 items-center">
                <!-- Cancel Button -->
                <a
                    href="{{ route('admin.cms.hero_sliders.index') }}"
                    class="transparent-button hover:bg-gray-200"
                >
                    @lang('admin::app.cms.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button 
                    type="submit" 
                    class="primary-button"
                >
                    Save Slider
                </button>
            </div>
        </div>

        <!-- body content -->
        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
            <!-- Left sub-component -->
            <div class="flex flex-col gap-2.5 flex-1 max-xl:flex-auto">
                <div class="p-4 bg-white rounded box-shadow">
                    <p class="text-base text-gray-800 font-semibold mb-4">
                        General
                    </p>

                    <!-- Slider Name -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            Name
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="name"
                            :value="old('name') ?: $heroSlider->name"
                            rules="required"
                            label="Name"
                            placeholder="Name"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="name"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Slider Code -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            Code (Identifier)
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="code"
                            :value="old('code') ?: $heroSlider->code"
                            rules="required"
                            label="Code"
                            placeholder="homepage-hero"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="code"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                </div>

                <!-- Slide & Layer Editor (Vue Component) -->
                <v-hero-slider-editor :slider-id="{{ $heroSlider->id }}" :initial-slides="{{ json_encode($heroSlider->slides) }}"></v-hero-slider-editor>
            </div>

            <!-- Right sub-component -->
            <div class="flex flex-col gap-2.5 w-[360px] max-w-full max-sm:w-full">
                <!-- Settings Panel -->
                <div class="p-4 bg-white rounded box-shadow">
                    <p class="text-base text-gray-800 font-semibold mb-4">
                        Settings
                    </p>

                    <!-- Status -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label>
                            Status
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="switch"
                            name="status"
                            class="cursor-pointer"
                            value="1"
                            label="Status"
                            :checked="(boolean) $heroSlider->status"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="status"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Autoplay Enabled -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label>
                            Autoplay
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="switch"
                            name="settings[autoplay]"
                            class="cursor-pointer"
                            value="1"
                            label="Autoplay"
                            :checked="(boolean) ($heroSlider->settings['autoplay'] ?? true)"
                        >
                        </x-admin::form.control-group.control>
                    </x-admin::form.control-group>

                    <!-- Autoplay Speed / Duration (ms) -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            Autoplay Speed (ms)
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="settings[duration]"
                            :value="old('settings.duration') ?: ($heroSlider->settings['duration'] ?? 6000)"
                            rules="required|numeric|min_value:1000"
                            label="Autoplay Speed (ms)"
                            placeholder="6000"
                        >
                        </x-admin::form.control-group.control>

                        <p class="text-xs text-gray-500 mt-1">
                            Duration per slide in milliseconds (e.g. 5000 = 5 seconds, 6000 = 6s, 8000 = 8s).
                        </p>
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>
    </x-admin::form>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-hero-slider-editor-template">
            <div class="p-4 bg-white rounded box-shadow mt-4">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="text-base text-gray-800 font-semibold">
                            Interactive Hero Slides
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Manage images, typography, highlights, buttons and duration for each slide.
                        </p>
                    </div>
                    <button type="button" @click="addSlide" class="secondary-button text-sm">
                        + Add Slide
                    </button>
                </div>

                <input type="hidden" name="slides_data" :value="JSON.stringify(slides)">

                <div v-if="slides.length === 0" class="text-gray-500 italic text-center py-8">
                    No slides added yet. Click "+ Add Slide" to begin.
                </div>

                <!-- Slide Accordion -->
                <div v-for="(slide, slideIndex) in slides" :key="slideIndex" class="mb-4 border border-gray-200 rounded overflow-hidden">
                    <!-- Slide Header -->
                    <div class="flex justify-between items-center bg-gray-50 p-3.5 cursor-pointer hover:bg-gray-100 transition-colors" @click="toggleSlide(slideIndex)">
                        <div class="font-medium text-gray-800 flex items-center gap-3">
                            <i :class="slide.expanded ? 'icon-arrow-down' : 'icon-arrow-right'" class="text-base text-gray-500"></i>
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-[#133b63] text-white text-xs font-bold">
                                @{{ slideIndex + 1 }}
                            </span>
                            <span class="font-semibold text-gray-900">
                                @{{ slide.name || 'Untitled Slide' }}
                            </span>
                            <span v-if="slide.settings && slide.settings.short_title" class="text-xs text-gray-500 font-normal">
                                • Tab: @{{ slide.settings.short_title }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Status Pill -->
                            <span
                                class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider"
                                :class="slide.status ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700'"
                            >
                                @{{ slide.status ? 'Active' : 'Draft' }}
                            </span>

                            <!-- Move Up -->
                            <button
                                type="button"
                                @click.stop="moveSlideUp(slideIndex)"
                                :disabled="slideIndex === 0"
                                class="p-1 rounded text-gray-500 hover:text-gray-900 disabled:opacity-30 disabled:cursor-not-allowed"
                                title="Move Up"
                            >
                                ▲
                            </button>

                            <!-- Move Down -->
                            <button
                                type="button"
                                @click.stop="moveSlideDown(slideIndex)"
                                :disabled="slideIndex === slides.length - 1"
                                class="p-1 rounded text-gray-500 hover:text-gray-900 disabled:opacity-30 disabled:cursor-not-allowed"
                                title="Move Down"
                            >
                                ▼
                            </button>

                            <!-- Remove Slide -->
                            <button
                                type="button"
                                @click.stop="removeSlide(slideIndex)"
                                class="p-1 text-red-600 hover:text-red-800 ml-1"
                                title="Delete Slide"
                            >
                                <i class="icon-delete text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Slide Content -->
                    <div v-show="slide.expanded" class="p-5 border-t border-gray-200 bg-white space-y-5">
                        <!-- Group 1: Slide Basics & Layout -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3 border-b pb-1">
                                1. Slide Settings & Timing
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Slide Admin Label *</label>
                                    <input type="text" v-model="slide.name" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="e.g. Everyday Bamboo Comfort">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Bottom Tab Label *</label>
                                    <input type="text" v-model="slide.settings.short_title" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="e.g. Everyday Comfort">
                                    <p class="text-[10px] text-gray-500 mt-0.5">Shown in bottom slider nav bar</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Slide Status</label>
                                    <select v-model="slide.status" class="w-full border border-gray-300 rounded p-2 text-sm">
                                        <option :value="1">Active</option>
                                        <option :value="0">Disabled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Group 2: Slide Imagery -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3 border-b pb-1">
                                2. Background Media
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Desktop Image Path / URL *</label>
                                    <input type="text" v-model="slide.desktop_media" class="w-full border border-gray-300 rounded p-2 text-sm font-mono text-xs" placeholder="images/hero-slide-1.webp">
                                    <p class="text-[10px] text-gray-500 mt-1">Relative to public folder (e.g. images/hero-slide-1.webp) or full URL.</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Mobile Image Path / URL (Optional)</label>
                                    <input type="text" v-model="slide.mobile_media" class="w-full border border-gray-300 rounded p-2 text-sm font-mono text-xs" placeholder="images/hero-slide-1.webp">
                                </div>
                            </div>
                            <!-- Image Preview -->
                            <div v-if="slide.desktop_media" class="mt-3 flex items-center gap-3 p-2 bg-gray-50 rounded border border-gray-200">
                                <img
                                    :src="slide.desktop_media.startsWith('http') || slide.desktop_media.startsWith('/') ? slide.desktop_media : '/' + slide.desktop_media"
                                    class="h-14 w-28 object-cover rounded shadow-sm border border-gray-300"
                                    onerror="this.style.display='none'"
                                />
                                <div class="text-xs text-gray-600">
                                    <p class="font-medium">Active Background Image</p>
                                    <p class="text-[11px] text-gray-500 font-mono">@{{ slide.desktop_media }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Group 3: Slide Typography & Copywriting -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3 border-b pb-1">
                                3. Headlines & Content
                            </h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Eyebrow Tagline</label>
                                    <input type="text" v-model="slide.settings.eyebrow" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="e.g. PREMIUM EVERYDAY SOCKS">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Headline Part 1 (White)</label>
                                        <input type="text" v-model="slide.settings.title_main" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="e.g. Comfort, Style &">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Headline Part 2 (Teal Highlight)</label>
                                        <input type="text" v-model="slide.settings.title_highlight" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="e.g. Support For Every Step">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Description Paragraph</label>
                                    <textarea v-model="slide.settings.description" rows="2" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="e.g. Premium socks designed for everyday comfort..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Group 4: Call-To-Action Buttons -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3 border-b pb-1">
                                4. Action Buttons (CTAs)
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Primary Orange Button -->
                                <div class="p-3 bg-orange-50/50 rounded border border-orange-200 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#f28c38]"></span>
                                        <span class="text-xs font-bold text-gray-800 uppercase tracking-wide">Primary Button (Solid Orange)</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Button Text</label>
                                        <input type="text" v-model="slide.settings.primary_btn_text" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="SHOP PREMIUM SOCKS">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Button Link URL</label>
                                        <input type="text" v-model="slide.settings.primary_btn_url" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="/products">
                                    </div>
                                </div>

                                <!-- Secondary Teal Button -->
                                <div class="p-3 bg-teal-50/50 rounded border border-teal-200 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#2ca7a3]"></span>
                                        <span class="text-xs font-bold text-gray-800 uppercase tracking-wide">Secondary Button (Teal Outline)</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Button Text</label>
                                        <input type="text" v-model="slide.settings.secondary_btn_text" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="EXPLORE COLLECTIONS">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Button Link URL</label>
                                        <input type="text" v-model="slide.settings.secondary_btn_url" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="/products">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Group 5: 4 Feature Highlights / Badges -->
                        <div v-if="slide.settings.badges && slide.settings.badges.length > 0">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3 border-b pb-1">
                                5. Feature Badges (4 Display Badges)
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                <div v-for="(badge, bIdx) in slide.settings.badges" :key="bIdx" class="p-2.5 bg-gray-50 rounded border border-gray-200 space-y-1.5">
                                    <p class="text-[11px] font-bold text-gray-700">Badge @{{ bIdx + 1 }}</p>
                                    <div>
                                        <label class="block text-[10px] text-gray-500">FA Icon Class</label>
                                        <input type="text" v-model="badge.icon" class="w-full border border-gray-300 rounded p-1 text-xs" placeholder="fa-solid fa-heart-pulse">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-gray-500">Line 1</label>
                                        <input type="text" v-model="badge.label1" class="w-full border border-gray-300 rounded p-1 text-xs" placeholder="Breathable">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-gray-500">Line 2</label>
                                        <input type="text" v-model="badge.label2" class="w-full border border-gray-300 rounded p-1 text-xs" placeholder="Comfort">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-hero-slider-editor', {
                template: '#v-hero-slider-editor-template',
                props: ['sliderId', 'initialSlides'],
                data() {
                    return {
                        slides: []
                    };
                },
                mounted() {
                    if (this.initialSlides && this.initialSlides.length > 0) {
                        this.slides = this.initialSlides.map(slide => {
                            let settings = {};
                            if (typeof slide.settings === 'string') {
                                try { settings = JSON.parse(slide.settings || '{}'); } catch(e) { settings = {}; }
                            } else if (slide.settings && typeof slide.settings === 'object') {
                                settings = { ...slide.settings };
                            }

                            if (!settings.badges || !Array.isArray(settings.badges)) {
                                settings.badges = [
                                    { icon: 'fa-solid fa-heart-pulse', label1: 'Breathable', label2: 'Comfort' },
                                    { icon: 'fa-solid fa-shield-halved', label1: 'Everyday', label2: 'Durability' },
                                    { icon: 'fa-solid fa-check', label1: 'Soft', label2: 'Support' },
                                    { icon: 'fa-solid fa-wind', label1: 'Modern', label2: 'Fit' }
                                ];
                            }

                            return {
                                ...slide,
                                status: slide.status !== undefined ? (slide.status ? 1 : 0) : 1,
                                duration: slide.duration || 6000,
                                expanded: false,
                                settings: {
                                    short_title: settings.short_title || slide.name || '',
                                    eyebrow: settings.eyebrow || '',
                                    title_main: settings.title_main || '',
                                    title_highlight: settings.title_highlight || '',
                                    description: settings.description || '',
                                    primary_btn_text: settings.primary_btn_text || 'SHOP PREMIUM SOCKS',
                                    primary_btn_url: settings.primary_btn_url || '/products',
                                    secondary_btn_text: settings.secondary_btn_text || 'EXPLORE COLLECTIONS',
                                    secondary_btn_url: settings.secondary_btn_url || '/products',
                                    badges: settings.badges
                                },
                                layers: (slide.layers || []).map(layer => ({
                                    ...layer,
                                    desktop_settings: typeof layer.desktop_settings === 'string' ? JSON.parse(layer.desktop_settings || '{}') : (layer.desktop_settings || {}),
                                    mobile_settings: typeof layer.mobile_settings === 'string' ? JSON.parse(layer.mobile_settings || '{}') : (layer.mobile_settings || {}),
                                    settings: typeof layer.settings === 'string' ? JSON.parse(layer.settings || '{}') : (layer.settings || {}),
                                }))
                            };
                        });
                    }
                },
                methods: {
                    addSlide() {
                        this.slides.push({
                            id: null,
                            name: 'Slide ' + (this.slides.length + 1),
                            status: 1,
                            media_type: 'image',
                            desktop_media: 'images/hero-slide-1.webp',
                            mobile_media: 'images/hero-slide-1.webp',
                            video_url: '',
                            duration: 6000,
                            expanded: true,
                            settings: {
                                short_title: 'Comfort',
                                eyebrow: 'PREMIUM EVERYDAY SOCKS',
                                title_main: 'Comfort, Style &',
                                title_highlight: 'Support For Every Step',
                                description: 'Premium socks designed for everyday comfort, movement, and modern lifestyles — for Men, Women & Children.',
                                primary_btn_text: 'SHOP PREMIUM SOCKS',
                                primary_btn_url: '/products',
                                secondary_btn_text: 'EXPLORE COLLECTIONS',
                                secondary_btn_url: '/products',
                                badges: [
                                    { icon: 'fa-solid fa-heart-pulse', label1: 'Breathable', label2: 'Comfort' },
                                    { icon: 'fa-solid fa-shield-halved', label1: 'Everyday', label2: 'Durability' },
                                    { icon: 'fa-solid fa-check', label1: 'Soft', label2: 'Support' },
                                    { icon: 'fa-solid fa-wind', label1: 'Modern', label2: 'Fit' }
                                ]
                            },
                            layers: []
                        });
                    },
                    removeSlide(index) {
                        if (confirm('Are you sure you want to remove this slide?')) {
                            this.slides.splice(index, 1);
                        }
                    },
                    toggleSlide(index) {
                        this.slides[index].expanded = !this.slides[index].expanded;
                    },
                    moveSlideUp(index) {
                        if (index > 0) {
                            const temp = this.slides[index];
                            this.slides.splice(index, 1);
                            this.slides.splice(index - 1, 0, temp);
                        }
                    },
                    moveSlideDown(index) {
                        if (index < this.slides.length - 1) {
                            const temp = this.slides[index];
                            this.slides.splice(index, 1);
                            this.slides.splice(index + 1, 0, temp);
                        }
                    }
                }
            });
        </script>
    @endPushOnce
</x-admin::layouts>
