@props([
    'isActive' => false,
    'position' => 'right',
    'width'    => '500px',
])

<v-drawer
    {{ $attributes }}
    is-active="{{ $isActive }}"
    position="{{ $position }}"
    width="{{ $width }}"
>
    @isset($toggle)
        <template v-slot:toggle>
            {{ $toggle }}
        </template>
    @endisset

    @isset($header)
        <template v-slot:header="{ close }">
            <div {{ $header->attributes->merge(['class' => 'relative flex items-center justify-between p-6 pb-5 border-b border-soxnsox-border bg-[#f8fafc]']) }}>
                <div class="flex-1">
                    {{ $header }}
                </div>

                <button
                    type="button"
                    class="flex h-9 w-9 items-center justify-center rounded-full text-soxnsox-charcoal hover:bg-black/5 hover:text-soxnsox-teal transition-colors focus:outline-none focus:ring-2 focus:ring-soxnsox-teal"
                    aria-label="Close Navigation"
                    @click="close"
                >
                    <i class="fa-solid fa-xmark text-lg" role="presentation"></i>
                </button>
            </div>
        </template>
    @endisset

    @isset($content)
        <template v-slot:content>
            <div {{ $content->attributes->merge(['class' => 'flex-1 overflow-auto bg-[#f8fafc]']) }}>
                {{ $content }}
            </div>
        </template>
    @endisset

    @isset($footer)
        <template v-slot:footer>
            <div {{ $footer->attributes->merge(['class' => 'p-6 border-t border-soxnsox-border bg-[#f8fafc]']) }}>
                {{ $footer }}
            </div>
        </template>
    @endisset
</v-drawer>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-drawer-template"
    >
        <div>
            <!-- Toggler -->
            <div @click="open">
                <slot name="toggle"></slot>
            </div>

            <teleport to="body">
                <!-- Overlay Backdrop with Premium Blur -->
                <transition
                    tag="div"
                    name="drawer-overlay"
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
                        v-show="isOpen"
                        @click="close"
                    ></div>
                </transition>

                <!-- Content Drawer -->
                <transition
                    tag="div"
                    name="drawer"
                    :enter-from-class="enterFromLeaveToClasses"
                    enter-active-class="transform transition duration-300 ease-in-out"
                    enter-to-class="translate-x-0"
                    leave-from-class="translate-x-0"
                    leave-active-class="transform transition duration-300 ease-in-out"
                    :leave-to-class="enterFromLeaveToClasses"
                >
                    <div
                        class="fixed overflow-hidden bg-[#f8fafc] shadow-2xl h-screen max-w-[100vw]"
                        :class="{
                            'inset-x-0 top-0': position == 'top',
                            'inset-x-0 bottom-0 max-sm:max-h-full': position == 'bottom',
                            'inset-y-0 ltr:right-0 rtl:left-0': position == 'right',
                            'inset-y-0 ltr:left-0 rtl:right-0': position == 'left'
                        }"
                        :style="'width:' + width + '; max-width: 100vw; z-index: 9999;'"
                        v-show="isOpen"
                    >
                        <div class="pointer-events-auto h-full w-full overflow-auto bg-[#f8fafc]">
                            <div class="flex h-full w-full flex-col">
                                <div class="min-h-0 min-w-0 flex-1 overflow-auto">
                                    <div class="flex h-full flex-col">
                                        <slot
                                            name="header"
                                            :close="close"
                                        >
                                            Default Header
                                        </slot>

                                        <!-- Content Slot -->
                                        <slot name="content"></slot>

                                        <!-- Footer Slot -->
                                        <slot name="footer"></slot>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </teleport>
        </div>
    </script>

    <script type="module">
        app.component('v-drawer', {
            template: '#v-drawer-template',

            props: [
                'isActive',
                'position',
                'width'
            ],

            data() {
                return {
                    isOpen: this.isActive,
                };
            },

            watch: {
                isActive: function(newVal, oldVal) {
                    this.isOpen = newVal;
                }
            },

            mounted() {
                window.addEventListener('keydown', this.handleKeydown);
            },

            beforeUnmount() {
                window.removeEventListener('keydown', this.handleKeydown);

                if (this.isOpen) {
                    document.body.style.overflow = 'auto';
                    document.body.style.paddingRight = '';
                }
            },

            computed: {
                enterFromLeaveToClasses() {
                    if (this.position == 'top') {
                        return '-translate-y-full';
                    } else if (this.position == 'bottom') {
                        return 'translate-y-full';
                    } else if (this.position == 'left') {
                        return 'ltr:-translate-x-full rtl:translate-x-full';
                    } else if (this.position == 'right') {
                        return 'ltr:translate-x-full rtl:-translate-x-full';
                    }
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

                    if (this.isOpen) {
                        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

                        document.body.style.overflow = 'hidden';

                        document.body.style.paddingRight = `${scrollbarWidth}px`;
                    } else {
                        document.body.style.overflow = 'auto';

                        document.body.style.paddingRight = '';
                    }

                    this.$emit('toggle', { isActive: this.isOpen });
                },

                open() {
                    this.isOpen = true;

                    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

                    document.body.style.overflow = 'hidden';

                    document.body.style.paddingRight = `${scrollbarWidth}px`;

                    this.$emit('open', { isActive: this.isOpen });
                },

                close() {
                    this.isOpen = false;

                    document.body.style.overflow = 'auto';

                    document.body.style.paddingRight = '';

                    this.$emit('close', { isActive: this.isOpen });
                }
            },
        });
    </script>
@endPushOnce
