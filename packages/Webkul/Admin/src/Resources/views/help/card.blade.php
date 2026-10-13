<a
    href="{{ $card['url'] }}"
    target="_blank"
    rel="noopener noreferrer"
    class="group relative flex flex-col rounded-xl border border-gray-200 bg-white p-6 transition-all duration-200 hover:-translate-y-0.5 hover:border-[#133b63]/20 hover:shadow-lg"
>
    <!-- External Link Indicator -->
    <span class="absolute right-5 top-5 text-gray-300 transition-colors group-hover:text-[#133b63]">
        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
    </span>

    <!-- Icon -->
    <span class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#133b63]/10 text-[#133b63] transition-colors group-hover:bg-[#133b63] group-hover:text-white">
        <i class="{{ $card['icon'] }} text-xl"></i>
    </span>

    <!-- Title -->
    <p class="mb-2 text-lg font-bold !leading-snug text-gray-800">
        {{ $card['title'] }}
    </p>

    <!-- Description -->
    <p class="!leading-relaxed text-gray-600">
        {{ $card['info'] }}
    </p>

    <!-- Footer host -->
    <span class="mt-5 border-t border-gray-100 pt-4 text-sm font-medium text-gray-400 transition-colors group-hover:text-[#133b63]">
        {{ $card['host'] }}
    </span>
</a>
