<div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
    @if (core()->getConfigData('general.general.breadcrumbs.shop'))
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <span class="text-[#133b63] font-semibold">Shipping &amp; Delivery Policy</span>
            </nav>
        </div>
    @endif

    <!-- HERO SECTION -->
    <section class="site-container pt-8 pb-14 sm:pt-12 sm:pb-16 border-b border-slate-200">
        <div class="max-w-3xl mx-auto text-center space-y-5 mb-8">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold tracking-widest uppercase border border-[#2ca7a3]/25 shadow-xs">
                <i class="fa-solid fa-truck-fast text-[#2ca7a3] text-sm"></i>
                <span>Pan-India Logistics &bull; Dispatched in 24 Hours</span>
            </div>

            <!-- Title -->
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#133b63] leading-[1.14]">
                Shipping &amp; Delivery Policy
            </h1>

            <div class="soxnsox-decorative-line-center my-3"></div>

            <p class="text-base sm:text-lg leading-relaxed text-[#6b7280]">
                At SOX N SOX, we are dedicated to delivering our premium bamboo and diabetic socks right to your doorstep quickly, reliably, and with 100% transparent tracking across 19,000+ PIN codes in India.
            </p>

            <p class="text-xs text-slate-400 font-medium">
                Last Updated: October 2026 &bull; Effective for all orders placed on soxnsox.in
            </p>
        </div>

        <!-- 4 Quick Highlights (Full site-container width) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 pt-6 text-left reveal-stagger">
            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#2ca7a3]">₹499+</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Free Delivery</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Complimentary express shipping across all states.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#f29a38]">24 Hrs</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Fast Dispatch</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Orders verified &amp; packed within 24 business hours.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#1d5b8f]">2 - 4 Days</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Metro Delivery</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Express delivery to Hyderabad, Bengaluru, Mumbai, etc.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#2ca7a3]">19,000+</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">PIN Codes</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Pan-India coverage via Blue Dart, Delhivery &amp; DTDC.</p>
            </div>
        </div>
    </section>

    <!-- MAIN POLICY CONTENT (Full site-container width with Sticky Sidebar Navigation) -->
    <section class="site-container py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Left Sticky Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
                <!-- Navigation Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                        <i class="fa-solid fa-list-check"></i>
                        <span>Policy Navigation</span>
                    </div>
                    <nav class="space-y-1 text-xs sm:text-sm font-medium">
                        <a href="#section-1" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">01</span>
                            <span>Processing &amp; Dispatch</span>
                        </a>
                        <a href="#section-2" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">02</span>
                            <span>Shipping Rates &amp; Free Delivery</span>
                        </a>
                        <a href="#section-3" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#1d5b8f]">03</span>
                            <span>Delivery Timelines by Region</span>
                        </a>
                        <a href="#section-4" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">04</span>
                            <span>Courier Partners &amp; Tracking</span>
                        </a>
                        <a href="#section-5" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">05</span>
                            <span>Cash on Delivery (COD)</span>
                        </a>
                        <a href="#section-6" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#1d5b8f]">06</span>
                            <span>Packaging &amp; Tamper Protocol</span>
                        </a>
                        <a href="#section-7" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">07</span>
                            <span>Delivery Attempts &amp; RTO</span>
                        </a>
                        <a href="#section-8" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">08</span>
                            <span>Logistics Helpdesk</span>
                        </a>
                    </nav>
                </div>

                <!-- Logistics Assistance Card -->
                <div class="bg-gradient-to-br from-[#133b63] to-[#0c243d] rounded-3xl p-6 text-white shadow-md space-y-4">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Track a Shipment?</span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Need instant help with an active order or delivery re-attempt?
                    </p>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center gap-2 text-slate-200">
                            <i class="fa-regular fa-envelope text-[#2ca7a3]"></i>
                            <span>support@soxnsox.in</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-200">
                            <i class="fa-solid fa-phone text-[#f29a38]"></i>
                            <span>+91 81061 55111</span>
                        </div>
                    </div>
                    <a
                        href="{{ route('shop.customers.account.orders.index') }}"
                        class="w-full text-center py-2.5 px-4 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2ca7a3] text-white hover:bg-[#238a87] transition-all block shadow-xs"
                    >
                        Track In Order History
                    </a>
                </div>
            </aside>

            <!-- Right Content Column (8 cols) -->
            <div class="lg:col-span-8 space-y-8">

                <!-- SECTION 1: DISPATCH & PROCESSING -->
                <div id="section-1" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        01
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Order Processing &amp; Dispatch Schedule
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        All footwear orders placed on <strong class="text-[#133b63]">soxnsox.in</strong> are picked, quality-checked, and packaged directly at our central fulfillment facility in Hyderabad, Telangana.
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Same-Day Processing:</strong> Orders confirmed before <strong class="text-[#133b63]">2:00 PM IST</strong> on business days (Monday through Saturday) are typically packed and prepared for carrier pickup on the same day.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">24-Hour Dispatch Guarantee:</strong> All orders are dispatched within <strong class="text-[#133b63]">24 business hours</strong> of payment confirmation or COD verification.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Sundays &amp; National Holidays:</strong> Orders placed on Sundays or gazetted public holidays are prioritized for dispatch on the next business morning.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Order Confirmation:</strong> Immediately after placing your order, an automated confirmation containing your unique Order ID is delivered to your registered email address and mobile number via SMS.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 2: SHIPPING CHARGES & THRESHOLD -->
            <div id="section-2" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff4e8] text-[#f29a38] font-bold text-sm">
                        02
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Shipping Rates &amp; Free Delivery Threshold
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        We believe in transparent, upfront pricing with no hidden handling or packaging surcharges at checkout:
                    </p>
                    
                    <div class="overflow-x-auto rounded-2xl border border-slate-200">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-[#f5f7fa] border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-[#133b63]">
                                <tr>
                                    <th class="py-3.5 px-4 sm:px-6">Order Cart Value</th>
                                    <th class="py-3.5 px-4 sm:px-6">Shipping Method</th>
                                    <th class="py-3.5 px-4 sm:px-6 text-right">Delivery Fee</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600">
                                <tr class="bg-teal-50/40">
                                    <td class="py-4 px-4 sm:px-6 font-semibold text-[#133b63]">
                                        ₹499.00 and above
                                    </td>
                                    <td class="py-4 px-4 sm:px-6 text-[#2ca7a3] font-semibold">
                                        <i class="fa-solid fa-gift mr-1.5"></i> Complimentary Express Delivery
                                    </td>
                                    <td class="py-4 px-4 sm:px-6 font-bold text-[#2ca7a3] text-right">
                                        FREE (₹0.00)
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-4 sm:px-6 font-semibold text-[#133b63]">
                                        Below ₹499.00 (e.g. Single Pair)
                                    </td>
                                    <td class="py-4 px-4 sm:px-6">
                                        Standard Express Courier Delivery
                                    </td>
                                    <td class="py-4 px-4 sm:px-6 font-semibold text-slate-800 text-right">
                                        ₹50.00 Flat Rate
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="text-xs text-slate-500 italic">
                        * Applicable coupon code discounts may reduce the cart value. The free shipping threshold of ₹499 is evaluated on the final payable subtotal after promotional coupons are applied.
                    </p>
                </div>
            </div>

            <!-- SECTION 3: ESTIMATED DELIVERY TIMELINES BY ZONE -->
            <div id="section-3" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf2f8] text-[#1d5b8f] font-bold text-sm">
                        03
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Estimated Delivery Timelines by Region
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        We partner with India's leading surface and air courier networks to guarantee prompt transit times:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-5 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-[#133b63]">Hyderabad &amp; Telangana</span>
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-teal-100 text-teal-800">1 - 2 Days</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Local hub proximity enables priority same-day dispatch and next-day door delivery across Hyderabad, Secunderabad, and major Telangana districts.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-[#133b63]">Major Metros (Tier 1)</span>
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800">2 - 4 Days</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Bengaluru, Chennai, Mumbai, Delhi-NCR, Kolkata, Pune, Ahmedabad, and Jaipur via air express routing.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-[#133b63]">Tier 2 &amp; Tier 3 Cities</span>
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800">3 - 6 Days</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                State capitals, district headquarters, and major commercial industrial towns across southern, western, northern, and central India.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-[#133b63]">Northeast, J&amp;K &amp; Islands</span>
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800">5 - 8 Days</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Assam, Meghalaya, Sikkim, Jammu &amp; Kashmir, Ladakh, Andaman &amp; Nicobar, and remote hill station postcodes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: REAL-TIME TRACKING & CARRIERS -->
            <div id="section-4" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        04
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Courier Partners &amp; Real-Time Tracking
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        To ensure safe transit, SOX N SOX ships orders exclusively through established, tier-1 national logistics providers:
                    </p>
                    <div class="flex flex-wrap items-center gap-3 py-2">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700">
                            <i class="fa-solid fa-box text-[#1d5b8f] mr-1.5"></i> Blue Dart Express
                        </span>
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700">
                            <i class="fa-solid fa-box text-[#2ca7a3] mr-1.5"></i> Delhivery Surface &amp; Air
                        </span>
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700">
                            <i class="fa-solid fa-box text-[#f29a38] mr-1.5"></i> Xpressbees Logistics
                        </span>
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700">
                            <i class="fa-solid fa-box text-[#133b63] mr-1.5"></i> DTDC Express
                        </span>
                    </div>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Automated Live Tracking:</strong> Once your consignment is handed over to the courier, an SMS and Email notification is dispatched containing your unique Air Waybill (AWB) number and direct tracking URL.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Account Dashboard Tracking:</strong> Registered users can monitor package progress anytime from their <a href="{{ route('shop.customers.account.orders.index') }}" class="text-[#1d5b8f] underline font-semibold hover:text-[#133b63]">Order History</a> section.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 5: CASH ON DELIVERY (COD) -->
            <div id="section-5" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff4e8] text-[#f29a38] font-bold text-sm">
                        05
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Cash on Delivery (COD) Guidelines
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        We understand that flexibility matters. Cash on Delivery is supported across serviceable pin codes in India with the following policies:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Order Verification:</strong> For first-time COD customers, our customer care desk may send an automated WhatsApp message or place a brief verification call to confirm address accuracy before handing the parcel to logistics.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Payment Readiness:</strong> Please ensure that exact cash or a UPI QR payment (via Google Pay, PhonePe, or Paytm) is ready upon delivery arrival. Most courier personnel now carry handheld UPI QR scanners.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Seal Verification Before Payment:</strong> In compliance with standard logistics carrier regulations across India, packages cannot be opened or tried on prior to handing payment to the delivery rider. If you encounter any sizing or fit concern after unboxing, our <a href="{{ route('shop.cms.page', 'return-policy') }}" class="text-[#1d5b8f] underline font-semibold hover:text-[#133b63]">7-Day Easy Replacement Policy</a> fully protects you.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 6: PACKAGING, TAMPERING & TRANSIT DAMAGE -->
            <div id="section-6" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf2f8] text-[#1d5b8f] font-bold text-sm">
                        06
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Tamper-Evident Packaging &amp; Damaged Delivery Protocol
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        Every pair of SOX N SOX socks is packed in hygienic, moisture-resistant, tamper-evident mailers designed to preserve pristine condition during transit.
                    </p>
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm space-y-2">
                        <p class="font-bold flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                            Important Delivery Inspection Notice:
                        </p>
                        <p>
                            If the outer courier parcel appears cut, torn, taped with non-branded clear tape, or visibly tampered with upon delivery arrival, <strong class="underline">please refuse acceptance</strong> from the courier agent and request them to mark it as "Tampered Parcel Refused".
                        </p>
                        <p>
                            If you accept the package and discover any manufacturing damage or missing items inside, photograph the outer box, label, and contents, and alert us at <a href="mailto:support@soxnsox.in" class="underline font-bold">support@soxnsox.in</a> or WhatsApp <a href="https://wa.me/918106155111" class="underline font-bold">+91 81061 55111</a> within <strong class="underline">24 hours of delivery</strong>. We will arrange an expedited free replacement immediately.
                        </p>
                    </div>
                </div>
            </div>

            <!-- SECTION 7: FAILED ATTEMPTS & ADDRESS ACCURACY -->
            <div id="section-7" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        07
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Delivery Attempts, Address Updates &amp; RTO
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">3 Delivery Attempts:</strong> Our delivery partners make up to three consecutive delivery attempts before marking a shipment as undeliverable. You will receive an SMS alert prior to each attempt.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Address Accuracy:</strong> Please ensure your full delivery address includes flat/house number, building name, street name, nearest landmark, correct city, state, and 6-digit postal PIN code along with an active 10-digit mobile number.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Address Correction Before Dispatch:</strong> If you notice an error in your address after ordering, reach out to us within 2 hours of placement. Once an AWB barcode is printed and dispatched, destination rerouting is subject to carrier operational feasibility.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Return to Origin (RTO):</strong> Parcels returned due to unreachable recipient or incorrect address can be re-dispatched upon address verification.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 8: WAREHOUSE & SUPPORT CONTACT -->
            <div id="section-8" class="rounded-3xl p-6 sm:p-10 bg-gradient-to-br from-[#133b63] to-[#0b1e32] text-white shadow-xl space-y-6 scroll-mt-28">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2ca7a3]/20 text-[#2ca7a3] border border-[#2ca7a3]/30">
                        <i class="fa-solid fa-headset"></i> Dedicated Logistics Desk
                    </span>
                    <h2 class="font-display text-2xl sm:text-3xl font-extrabold mt-3">
                        Have Questions About Your Shipment?
                    </h2>
                    <p class="text-slate-300 text-sm mt-2 max-w-xl">
                        Our logistics coordinators are available Monday to Saturday (9:30 AM – 6:30 PM IST) to assist with live tracking, courier coordination, and delivery scheduling.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 text-sm">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-[#2ca7a3] font-bold uppercase tracking-wider">Email Tracking Desk</p>
                        <p class="font-semibold text-white">support@soxnsox.in</p>
                        <p class="text-[11px] text-slate-400">Response within 4-6 business hours</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-[#f29a38] font-bold uppercase tracking-wider">Direct WhatsApp / Phone</p>
                        <p class="font-semibold text-white">+91 81061 55111</p>
                        <p class="text-[11px] text-slate-400">Instant dispatch &amp; tracking updates</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-teal-300 font-bold uppercase tracking-wider">Central Dispatch Hub</p>
                        <p class="font-semibold text-white">Hyderabad, Telangana</p>
                        <p class="text-[11px] text-slate-400">ALEAP Industrial Estate - 500090</p>
                    </div>
                </div>

                <div class="pt-2 flex flex-wrap gap-4">
                    <a
                        href="{{ route('shop.home.contact_us') }}"
                        class="px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider text-[#133b63] bg-white hover:bg-slate-100 transition-all shadow-md active:scale-95 inline-flex items-center gap-2"
                    >
                        <span>Contact Support Desk</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a
                        href="{{ route('shop.search.index') }}"
                        class="px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider text-white bg-[#2ca7a3] hover:bg-[#238a87] transition-all shadow-md active:scale-95 inline-flex items-center gap-2"
                    >
                        <span>Continue Shopping</span>
                        <i class="fa-solid fa-bag-shopping text-xs"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
</div>
