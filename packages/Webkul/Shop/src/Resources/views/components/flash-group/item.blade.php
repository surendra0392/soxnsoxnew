<v-flash-item
    v-for='flash in flashes'
    :key='flash.uid'
    :flash="flash"
    @onRemove="remove($event)"
/>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-flash-item-template"
    >
        <div
            class="flex w-max max-w-[408px] justify-between gap-12 rounded-lg px-5 py-3 max-sm:max-w-80 max-sm:items-center max-sm:gap-2 max-sm:p-3"
            :style="typeStyles[flash.type]['container']"
        >
            <p
                class="flex items-center break-words text-sm"
                :style="typeStyles[flash.type]['message']"
            >
                <i
                    class="text-xl ltr:mr-2.5 rtl:ml-2.5 shrink-0"
                    :class="iconClasses[flash.type]"
                    :style="typeStyles[flash.type]['icon']"
                ></i>

                @{{ flash.message }}
            </p>

            <button
                type="button"
                class="cursor-pointer shrink-0 opacity-70 hover:opacity-100 transition-opacity"
                :style="typeStyles[flash.type]['icon']"
                aria-label="Close alert"
                @click="remove"
            >
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    </script>

    <script type="module">
        app.component('v-flash-item', {
            template: '#v-flash-item-template',

            props: ['flash'],

            data() {
                return {
                    iconClasses: {
                        success: 'fa-solid fa-circle-check',

                        error: 'fa-solid fa-circle-xmark',

                        warning: 'fa-solid fa-triangle-exclamation',

                        info: 'fa-solid fa-circle-info',
                    },

                    typeStyles: {
                        success: {
                            container: 'background: #D4EDDA',

                            message: 'color: #155721',

                            icon: 'color: #155721'
                        },

                        error: {
                            container: 'background: #F8D7DA',

                            message: 'color: #721C24',

                            icon: 'color: #721C24'
                        },

                        warning: {
                            container: 'background: #FFF3CD',

                            message: 'color: #856404',

                            icon: 'color: #856404'
                        },

                        info: {
                            container: 'background: #E2E3E5',

                            message: 'color: #383D41',

                            icon: 'color: #383D41'
                        },
                    },
                };
            },

            mounted() {
                var self = this;

                setTimeout(function() {
                    self.remove()
                }, 2000)
            },

            methods: {
                remove() {
                    this.$emit('onRemove', this.flash)
                }
            }
        });
    </script>
@endpushOnce
