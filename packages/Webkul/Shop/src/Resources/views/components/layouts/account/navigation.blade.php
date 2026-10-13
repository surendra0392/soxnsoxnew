@php
    $customer = auth()->guard('customer')->user();
@endphp

<div class="w-full lg:w-[300px] xl:w-[320px] shrink-0 space-y-6">
    <!-- Account Profile Card -->
    <div class="rounded-3xl border border-soxnsox-border/80 bg-white p-6 shadow-soxnsox-subtle space-y-4">
        <div class="flex items-center gap-4">
            <div class="shrink-0 w-12 h-12 rounded-full overflow-hidden border border-slate-200 shadow-sm">
                <img
                    src="{{ $customer?->avatar_url ?? soxnsox_avatar($customer?->first_name ?? 'User', 80) }}"
                    alt="{{ $customer?->first_name ?? 'User' }}"
                    class="h-full w-full object-cover"
                >
            </div>

            <div class="min-w-0" v-pre>
                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-[#e9f2fa] text-[#2ca7a3] text-[9px] font-semibold tracking-wider uppercase">
                    <i class="fa-solid fa-feather text-[10px]"></i>
                    <span>Account</span>
                </div>
                <h3 class="font-display text-base font-bold text-[#133b63] truncate mt-0.5">
                    {{ $customer->first_name }} {{ $customer->last_name }}
                </h3>
                <p class="text-xs text-slate-500 truncate">
                    {{ $customer->email }}
                </p>
            </div>
        </div>

        <!-- Account Navigation Menu -->
        <nav class="pt-4 border-t border-soxnsox-border/60 space-y-1">
            @foreach (menu()->getItems('customer') as $menuItem)
                @if ($menuItem->haveChildren())
                    @foreach ($menuItem->getChildren() as $subMenuItem)
                        <a
                            href="{{ $subMenuItem->getUrl() }}"
                            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-semibold transition-all {{ $subMenuItem->isActive() ? 'bg-teal-50 text-[#2ca7a3] font-bold border border-[#2ca7a3]/40 shadow-xs' : 'text-[#133b63] hover:bg-slate-50 hover:text-[#2ca7a3]' }}"
                        >
                            <span class="flex items-center gap-3">
                                <span class="{{ $subMenuItem->getIcon() }} text-base text-[#2ca7a3]"></span>
                                <span>{{ $subMenuItem->getName() }}</span>
                            </span>

                            <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                        </a>
                    @endforeach
                @endif
            @endforeach
        </nav>

        <!-- Logout Action -->
        <div class="pt-4 border-t border-soxnsox-border/60">
            <x-shop::form
                method="DELETE"
                action="{{ route('shop.customer.session.destroy') }}"
                id="customerLogoutNav"
            />

            <button
                type="button"
                class="soxnsox-btn-outline soxnsox-btn-shimmer h-10 w-full text-xs uppercase tracking-widest font-bold rounded-full flex items-center justify-center gap-2 active:scale-95 transition-all duration-300"
                onclick="event.preventDefault(); document.getElementById('customerLogoutNav').submit();"
            >
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                <span>@lang('shop::app.components.layouts.header.desktop.bottom.logout')</span>
            </button>
        </div>
    </div>
</div>