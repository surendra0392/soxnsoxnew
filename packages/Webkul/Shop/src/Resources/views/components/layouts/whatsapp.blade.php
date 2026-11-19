@php
    $whatsappPhone = '918106155111';
    $whatsappText = urlencode('Hello SOX N SOX, I would like to inquire about your bamboo socks.');
    $whatsappUrl = "https://wa.me/{$whatsappPhone}?text={$whatsappText}";
@endphp

<div
    id="soxnsox-whatsapp-float"
    class="fixed bottom-20 right-5 sm:bottom-24 sm:right-8 z-[90] flex items-center group"
>
    <!-- Tooltip (Desktop) -->
    <span
        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#133b63] text-white text-xs font-semibold shadow-xl border border-white/20 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300 pointer-events-none mr-3 whitespace-nowrap"
    >
        <span class="w-2 h-2 rounded-full bg-[#25D366] animate-pulse"></span>
        Chat with us
    </span>

    <!-- WhatsApp Floating Action Button -->
    <a
        href="{{ $whatsappUrl }}"
        target="_blank"
        rel="noopener noreferrer"
        class="relative flex items-center justify-center w-12 h-12 rounded-full text-white shadow-2xl transition-all duration-300 hover:scale-110 active:scale-95 focus:outline-none focus:ring-4 focus:ring-[#25D366]/40 cursor-pointer"
        style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); border: 2px solid #ffffff; box-shadow: 0 10px 25px rgba(37, 211, 102, 0.45);"
        aria-label="Chat with SOX N SOX on WhatsApp"
        title="Chat on WhatsApp (+91 81061 55111)"
    >
        <!-- Soft Pulse Glow Ring -->
        <span class="absolute inset-0 rounded-full bg-[#25D366] opacity-30 animate-ping pointer-events-none"></span>

        <!-- WhatsApp Brand Icon -->
        <i class="fa-brands fa-whatsapp text-2xl text-white relative z-10 transition-transform duration-300 group-hover:rotate-6"></i>
    </a>
</div>
