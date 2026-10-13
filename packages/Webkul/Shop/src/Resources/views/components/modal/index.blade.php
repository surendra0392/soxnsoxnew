@props([
    'isActive' => false,
])

<v-modal
    is-active="{{ $isActive }}"
    {{ $attributes }}
>
    @isset($toggle)
        <template v-slot:toggle>
            {{ $toggle }}
        </template>
    @endisset

    @isset($header)
        <template v-slot:header="{ toggle, isOpen }">
            <div {{ $header->attributes->merge(['class' => 'flex items-center justify-between gap-5 border-b border-zinc-200 bg-white p-8 max-sm:px-4 max-sm:py-3']) }}>
                {{ $header }}

                <button
                    type="button"
                    class="cursor-pointer text-slate-400 hover:text-soxnsox-charcoal transition-colors p-1"
                    aria-label="Close modal"
                    @click="toggle"
                >
                    <i class="fa-solid fa-xmark text-xl max-sm:text-lg"></i>
                </button>
            </div>
        </template>
    @endisset

    @isset($content)
        <template v-slot:content>
            <div {{ $content->attributes->merge(['class' => 'bg-white p-8 max-sm:p-5']) }}>
                {{ $content }}
            </div>
        </template>
    @endisset

    @isset($footer)
        <template v-slot:footer>
            <div {{ $footer->attributes->merge(['class' => 'mt-5 bg-white p-8 max-sm:mt-0.5 max-sm:py-4 max-sm:px-4']) }}>
                {{ $footer }}
            </div>
        </template>
    @endisset
</v-modal>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-modal-template"
    >
        <div>
            <div @click="toggle">
                <slot name="toggle">
                </slot>
            </div>

            <teleport to="body">
                <transition
                    tag="div"
                    name="modal-overlay"
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

                <transition
                    tag="div"
                    name="modal-content"
                    enter-active-class="transition-all duration-300 ease-out"
                    enter-from-class="translate-y-4 opacity-0 md:translate-y-0 md:scale-95"
                    enter-to-class="translate-y-0 opacity-100 md:scale-100"
                    leave-active-class="transition-all duration-200 ease-in"
                    leave-from-class="translate-y-0 opacity-100 md:scale-100"
                    leave-to-class="translate-y-4 opacity-0 md:translate-y-0 md:scale-95"
                >
                    <div
                        class="fixed inset-0 transform overflow-y-auto transition"
                        style="position: fixed; inset: 0; z-index: 9999;"
                        v-show="isOpen"
                        @click.self="close"
                    >
                        <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
                            <div
                                class="relative z-10 w-full overflow-hidden rounded-2xl bg-white shadow-2xl max-md:w-[90%]"
                                :class="panelClass || 'max-w-[595px]'"
                            >
                                <!-- Header Slot-->
                                <slot
                                    name="header"
                                    :toggle="toggle"
                                    :isOpen="isOpen"
                                >
                                </slot>

                                <!-- Content Slot-->
                                <slot name="content"></slot>

                                <!-- Footer Slot-->
                                <slot name="footer"></slot>
                            </div>
                        </div>
                    </div>
                </transition>
            </teleport>
        </div>
    </script>

    <script type="module">
        app.component('v-modal', {
            template: '#v-modal-template',

            props: ['isActive', 'panelClass'],

            data() {
                return {
                    isOpen: this.isActive,
                };
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
                        document.body.style.overflow ='auto';

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
            }
        });
    </script>
@endPushOnce
