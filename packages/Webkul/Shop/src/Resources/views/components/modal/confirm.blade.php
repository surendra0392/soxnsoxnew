<v-modal-confirm ref="confirmModal"></v-modal-confirm>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-modal-confirm-template"
    >
        <div>
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
                        style="position: fixed; inset: 0; z-index: 10001; background-color: rgba(12, 31, 51, 0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
                        v-show="isOpen"
                        @click="disagree"
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
                        style="position: fixed; inset: 0; z-index: 10002;"
                        v-show="isOpen"
                        @click.self="disagree"
                    >
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <div class="relative z-10 w-full max-w-[475px] overflow-hidden rounded-2xl bg-white p-6 shadow-2xl max-md:w-[92%] max-sm:p-4">
                                <div class="flex gap-3.5 items-start">
                                    <div class="shrink-0">
                                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-amber-50 border border-amber-200">
                                            <i class="fa-solid fa-triangle-exclamation text-amber-500 text-xl max-sm:text-lg"></i>
                                        </span>
                                    </div>

                                    <div class="flex-1 text-left">
                                        <div class="flex items-center justify-between gap-5 text-xl font-bold text-[#133b63] max-sm:text-lg">
                                            @{{ title }}
                                        </div>

                                        <div class="pb-5 pt-2 text-left text-sm text-slate-600 leading-relaxed">
                                            @{{ message }}
                                        </div>

                                        <div class="flex justify-end gap-3">
                                            <button
                                                type="button"
                                                class="secondary-button max-md:py-3 max-sm:px-6 max-sm:py-2.5"
                                                @click="disagree"
                                            >
                                                @{{ options.btnDisagree }}
                                            </button>

                                            <button
                                                type="button"
                                                class="primary-button max-md:py-3 max-sm:px-6 max-sm:py-2.5"
                                                @click="agree"
                                            >
                                                @{{ options.btnAgree }} 
                                            </button>
                                        </div>
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
        app.component('v-modal-confirm', {
            template: '#v-modal-confirm-template',

            data() {
                return {
                    isOpen: false,

                    title: '',

                    message: '',

                    options: {
                        btnDisagree: '',
                        btnAgree: '',
                    },

                    agreeCallback: null,

                    disagreeCallback: null,
                };
            },

            created() {
                this.registerGlobalEvents();
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
                        this.disagree();
                    }
                },

                open({
                    title = "@lang('shop::app.components.modal.confirm.title')",
                    message = "@lang('shop::app.components.modal.confirm.message')",
                    options = {
                        btnDisagree: "@lang('shop::app.components.modal.confirm.disagree-btn')",
                        btnAgree: "@lang('shop::app.components.modal.confirm.agree-btn')",
                    },
                    agree = () => {},
                    disagree = () => {},
                }) {
                    this.isOpen = true;

                    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

                    document.body.style.overflow = 'hidden';

                    document.body.style.paddingRight = `${scrollbarWidth}px`;

                    this.title = title;

                    this.message = message;

                    this.options = options;

                    this.agreeCallback = agree;

                    this.disagreeCallback = disagree;
                },

                disagree() {
                    this.isOpen = false;

                    document.body.style.overflow = 'auto';

                    document.body.style.paddingRight = '';

                    this.disagreeCallback();
                },

                agree() {
                    this.isOpen = false;

                    document.body.style.overflow = 'auto';

                    document.body.style.paddingRight = '';

                    this.agreeCallback();
                },

                registerGlobalEvents() {
                    this.$emitter.on('open-confirm-modal', this.open);
                },
            }
        });
    </script>
@endPushOnce
