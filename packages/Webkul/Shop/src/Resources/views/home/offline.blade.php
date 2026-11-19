<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        Offline — No Internet Connection | SOX N SOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4 sm:px-6">
        <main class="w-full max-w-lg mx-auto text-center space-y-6 bg-white p-8 sm:p-12 rounded-3xl border border-[#e5e7eb] shadow-xl">
            <!-- Offline Signal Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#e9f2fa] text-[#133b63] shadow-inner">
                <i class="fa-solid fa-plane-slash text-3xl text-[#133b63]"></i>
            </div>

            <!-- Status Pill -->
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#fef2f2] text-[#dc2626] text-xs font-bold tracking-widest uppercase border border-[#fee2e2]">
                    <span class="w-2 h-2 rounded-full bg-[#dc2626] animate-pulse"></span>
                    <span>You're Currently Offline</span>
                </span>
            </div>

            <!-- Headline & Description -->
            <div class="space-y-3">
                <h1 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-[#133b63]">
                    No Internet Connection
                </h1>

                <div class="w-12 h-1 bg-[#2ca7a3] rounded-full mx-auto"></div>

                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    It looks like you’ve lost connection to the internet. Any previously visited pages are still available in your cache, but new products or orders require an active connection.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                <button
                    type="button"
                    onclick="window.location.reload();"
                    class="w-full sm:w-auto px-7 py-3.5 bg-[#133b63] hover:bg-[#1d5b8f] text-white text-xs uppercase tracking-widest font-bold rounded-full inline-flex items-center justify-center gap-2 shadow-lg hover:shadow-xl active:scale-95 transition-all duration-300"
                >
                    <i class="fa-solid fa-rotate-right text-xs"></i>
                    <span>Try Reconnecting</span>
                </button>

                <a
                    href="{{ route('shop.home.index') }}"
                    class="w-full sm:w-auto px-7 py-3.5 bg-white hover:bg-slate-50 text-[#133b63] border border-[#133b63]/20 hover:border-[#133b63] text-xs uppercase tracking-widest font-bold rounded-full inline-flex items-center justify-center gap-2 active:scale-95 transition-all duration-300"
                >
                    <i class="fa-solid fa-house text-xs"></i>
                    <span>Cached Home</span>
                </a>
            </div>

            <!-- Helpline Footnote -->
            <div class="pt-6 border-t border-slate-100 text-xs text-slate-500 space-y-1">
                <p>Need urgent assistance with an existing order?</p>
                <p class="font-medium text-[#133b63]">
                    Call <a href="tel:+918106155111" class="underline hover:text-[#2ca7a3]">+91-81061-55111</a> or Email <a href="mailto:support@soxnsox.in" class="underline hover:text-[#2ca7a3]">support@soxnsox.in</a>
                </p>
            </div>
        </main>
    </div>
</x-shop::layouts>
