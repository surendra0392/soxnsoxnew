@props([
    'average' => 0,
    'total'   => 0,
    'rating' => true,
])

<v-product-ratings
    {{ $attributes->merge(['class' => 'flex w-max items-center rounded-md border border-zinc-200 px-4 py-2']) }}
    average="{{ $average }}"
    total="{{ $total }}"
>
</v-product-ratings>

@pushOnce("scripts")
    <script
        type="text/x-template"
        id="v-product-ratings-template"
    >
        <div>
            <span class="text-sm font-medium text-black max-sm:text-xs">
                @{{ average }}
            </span>
        
            <i
                class="fa-solid fa-star text-amber-500 text-sm max-sm:text-xs"
                role="presentation"
            ></i>
            
            <span class="border-l border-zinc-300 text-xs font-medium text-soxnsox-charcoal ltr:pl-1.5 rtl:pr-1.5">
                @{{ abbreviatedTotal }} <span v-if="rating">Ratings</span>
            </span>
        </div>
    </script>

    <script type="module">
        app.component("v-product-ratings", {
            template: "#v-product-ratings-template",

            props: {
                average: {
                    type: String,
                    required: true,
                },

                total: {
                    type: String,
                    required: true,
                },

                rating: {
                    type: Boolean,
                    required: false,
                },
            },

            computed: {
                starColorClasses() {
                    return {
                        'text-emerald-600': this.average > 4,
                        'text-emerald-500': this.average >= 4 && this.average < 5,
                        'text-emerald-400': this.average >= 3 && this.average < 4,
                        'text-amber-500': this.average >= 2 && this.average < 3,
                        'text-red-500': this.average >= 1 && this.average < 2,
                        'text-gray-400': this.average <= 0,
                    };
                },

                abbreviatedTotal() {
                    if (this.total >= 1000) {
                        return `${(this.total / 1000).toFixed(1)}k`;
                    }

                    return this.total;
                },
            },
        });
    </script>
@endPushOnce
