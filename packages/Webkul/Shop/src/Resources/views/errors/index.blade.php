<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang("shop::app.errors.{$errorCode}.title") | SOXNSOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-[calc(100vh-160px)] flex items-center justify-center">
        <main class="site-container py-16 sm:py-24 text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#e9f2fa] text-[#1d5b8f] text-xs font-semibold tracking-widest uppercase">
                <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                <span>Error {{ $errorCode }}</span>
            </div>

            <div class="space-y-3 max-w-lg mx-auto">
                <h1 class="font-display text-3xl sm:text-5xl font-extrabold tracking-tight text-[#133b63]">
                    @lang("shop::app.errors.{$errorCode}.title")
                </h1>

                <div class="soxnsox-decorative-line-center"></div>

                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    {{ 
                        $errorCode === 503 && core()->getCurrentChannel()->maintenance_mode_text != ""
                        ? core()->getCurrentChannel()->maintenance_mode_text : trans("shop::app.errors.{$errorCode}.description")
                    }}
                </p>
            </div>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a 
                    href="{{ route('shop.home.index') }}"
                    class="soxnsox-btn-primary soxnsox-btn-shimmer h-12 px-8 text-xs uppercase tracking-widest font-bold rounded-full inline-flex items-center gap-2 shadow-soxnsox-card active:scale-95 transition-all duration-300"
                >
                    <span>@lang('shop::app.errors.go-to-home')</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>

                <a 
                    href="{{ route('shop.search.index') }}"
                    class="soxnsox-btn-outline soxnsox-btn-shimmer h-12 px-8 text-xs uppercase tracking-widest font-bold rounded-full inline-flex items-center gap-2 active:scale-95 transition-all duration-300"
                >
                    <span>Explore Bamboo Socks</span>
                </a>
            </div>
        </main>
    </div>
</x-shop::layouts>