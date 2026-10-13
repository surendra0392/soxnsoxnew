@props(['position' => 'left'])

<v-tabs
    position="{{ $position }}"
    {{ $attributes }}
>
    <x-shop::shimmer.tabs />
</v-tabs>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-tabs-template"
    >
        <div>
            <div
                class="flex flex-row flex-wrap gap-1 sm:gap-4 md:gap-8 border-b border-soxnsox-border/80 bg-transparent"
                :class="position === 'center' ? 'justify-center' : 'justify-start'"
            >
                <div
                    role="button"
                    tabindex="0"
                    v-for="tab in tabs"
                    class="group relative cursor-pointer px-4 sm:px-6 py-3 sm:py-3.5 text-xs sm:text-sm md:text-sm font-bold uppercase tracking-wider transition-all duration-200 select-none focus:outline-none"
                    :class="tab.isActive ? 'text-[#133b63]' : 'text-slate-400 hover:text-[#133b63]'"
                    :id="tab.$attrs.id + '-button'"
                    @click="change(tab)"
                >
                    <span>@{{ tab.title }}</span>
                    <!-- Active Brand Teal Underline Indicator -->
                    <span
                        class="absolute bottom-0 left-2 right-2 h-[3px] bg-[#2ca7a3] rounded-full transition-all duration-300"
                        v-if="tab.isActive"
                    ></span>
                    <span
                        class="absolute bottom-0 left-2 right-2 h-[3px] bg-transparent group-hover:bg-[#2ca7a3]/30 rounded-full transition-all duration-300"
                        v-else
                    ></span>
                </div>
            </div>

            <div>
                {{ $slot }}
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-tabs', {
            template: '#v-tabs-template',

            props: ['position'],

            data() {
                return {
                    tabs: []
                }
            },

            computed: {
                positionStyles() {
                    return [
                        `justify-content: ${this.position}`
                    ];
                },
            },

            methods: {
                change(selectedTab) {
                    this.tabs.forEach(tab => {
                        tab.isActive = (tab.title == selectedTab.title);
                    });
                },
            },
        });
    </script>
@endPushOnce
