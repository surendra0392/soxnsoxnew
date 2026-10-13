@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 sm:p-6 bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xs mt-8">
        <p class="text-xs sm:text-sm font-medium text-slate-500">
            @lang('shop::app.partials.pagination.pagination-showing', [
                'firstItem' => $paginator->firstItem(),
                'lastItem'  => $paginator->lastItem(),
                'total'     => $paginator->total(),
            ])
        </p>

        <nav aria-label="Page Navigation">
            <ul class="inline-flex items-center gap-1.5 sm:gap-2">
                <!-- Previous Page Link -->
                <li>
                    @if ($paginator->onFirstPage())
                        <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-300 cursor-not-allowed text-xs" aria-disabled="true">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </span>
                    @else
                        <a 
                            href="{{ urldecode($paginator->previousPageUrl()) }}" 
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200/90 bg-white text-xs font-semibold text-[#133b63] hover:border-[#2ca7a3] hover:text-[#2ca7a3] hover:bg-teal-50/40 transition-all duration-200 shadow-xs active:scale-95" 
                            aria-label="{{ trans('shop::app.partials.pagination.prev-page') }}"
                        >
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </a>
                    @endif
                </li>
    
                <!-- Pagination Elements -->
                @foreach ($elements as $element) 
                    @if (is_string($element)) 
                        <li>
                            <span class="flex h-10 min-w-10 px-2 items-center justify-center text-xs font-bold text-slate-400">
                                {{ $element }}
                            </span>
                        </li>
                    @endif 

                    @if (is_array($element)) 
                        @foreach ($element as $page => $url) 
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span 
                                        class="flex h-10 min-w-10 px-3.5 items-center justify-center rounded-full bg-[#133b63] text-white font-bold text-xs shadow-md border border-[#133b63] cursor-default"
                                        aria-current="page"
                                    >
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a 
                                        href="{{ $url }}" 
                                        class="flex h-10 min-w-10 px-3.5 items-center justify-center rounded-full border border-slate-200/90 bg-white text-xs font-semibold text-[#133b63] hover:border-[#2ca7a3] hover:text-[#2ca7a3] hover:bg-teal-50/40 transition-all duration-200 shadow-xs active:scale-95"
                                    >
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach 
                    @endif 
                @endforeach

                <!-- Next Page Link -->
                <li>
                    @if ($paginator->hasMorePages())
                        <a 
                            href="{{ urldecode($paginator->nextPageUrl()) }}" 
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200/90 bg-white text-xs font-semibold text-[#133b63] hover:border-[#2ca7a3] hover:text-[#2ca7a3] hover:bg-teal-50/40 transition-all duration-200 shadow-xs active:scale-95" 
                            aria-label="{{ trans('shop::app.partials.pagination.next-page') }}"
                        >
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-300 cursor-not-allowed text-xs" aria-disabled="true">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </span>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
@endif
