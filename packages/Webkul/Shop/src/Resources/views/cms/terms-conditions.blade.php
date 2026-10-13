<div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
    @if (core()->getConfigData('general.general.breadcrumbs.shop'))
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <span class="text-[#133b63] font-semibold">Terms &amp; Conditions</span>
            </nav>
        </div>
    @endif

    <!-- HERO SECTION -->
    <section class="site-container pt-8 pb-14 sm:pt-12 sm:pb-16 border-b border-slate-200">
        <div class="max-w-3xl mx-auto text-center space-y-5 mb-8">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold tracking-widest uppercase border border-[#2ca7a3]/25 shadow-xs">
                <i class="fa-solid fa-scale-balanced text-[#2ca7a3] text-sm"></i>
                <span>Legal Guidelines &bull; Consumer Rights &bull; Fair Terms</span>
            </div>

            <!-- Title -->
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#133b63] leading-[1.14]">
                Terms &amp; Conditions of Sale
            </h1>

            <div class="soxnsox-decorative-line-center my-3"></div>

            <p class="text-base sm:text-lg leading-relaxed text-[#6b7280]">
                Welcome to SOX N SOX. Please review these Terms and Conditions carefully. They outline your legal rights, responsibilities, order policies, and medical disclaimers when purchasing from soxnsox.in.
            </p>

            <p class="text-xs text-slate-400 font-medium">
                Last Updated: October 2026 &bull; Governed by the Laws of the Republic of India
            </p>
        </div>

        <!-- 4 Core Protections (Full site-container width) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 pt-6 text-left reveal-stagger">
            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#2ca7a3]">100% GST</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Included Prices</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">All prices in INR inclusive of all Indian statutory taxes.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#f29a38]">Medical</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Footwear Notice</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Clear guidelines for diabetic &amp; circulatory comfort socks.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#1d5b8f]">7-Day</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Exchange Policy</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Easy replacement on unworn socks with tags intact.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#2ca7a3]">Hyderabad</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Legal Jurisdiction</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Dispute settlement in courts of Telangana, India.</p>
            </div>
        </div>
    </section>

    <!-- MAIN TERMS CONTENT (Full site-container width with Sticky Sidebar Navigation) -->
    <section class="site-container py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Left Sticky Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
                <!-- Navigation Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                        <i class="fa-solid fa-scale-balanced"></i>
                        <span>Terms Navigation</span>
                    </div>
                    <nav class="space-y-1 text-xs sm:text-sm font-medium">
                        <a href="#section-1" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">01</span>
                            <span>Agreement &amp; Eligibility</span>
                        </a>
                        <a href="#section-2" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">02</span>
                            <span>Medical Disclaimer</span>
                        </a>
                        <a href="#section-3" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#1d5b8f]">03</span>
                            <span>Pricing, Taxes &amp; Payments</span>
                        </a>
                        <a href="#section-4" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">04</span>
                            <span>Order Workflow &amp; Cancellation</span>
                        </a>
                        <a href="#section-5" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">05</span>
                            <span>Shipping &amp; Delivery</span>
                        </a>
                        <a href="#section-6" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#1d5b8f]">06</span>
                            <span>Returns &amp; Hygiene Policy</span>
                        </a>
                        <a href="#section-7" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">07</span>
                            <span>Intellectual Property</span>
                        </a>
                        <a href="#section-8" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">08</span>
                            <span>Limitation of Liability</span>
                        </a>
                        <a href="#section-9" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#1d5b8f]">09</span>
                            <span>Governing Law &amp; Jurisdiction</span>
                        </a>
                    </nav>
                </div>

                <!-- Legal Assistance Card -->
                <div class="bg-gradient-to-br from-[#133b63] to-[#0c243d] rounded-3xl p-6 text-white shadow-md space-y-4">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                        <i class="fa-solid fa-gavel"></i>
                        <span>Need Legal Clarity?</span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Questions about our sales terms, medical disclaimers, or institutional orders?
                    </p>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center gap-2 text-slate-200">
                            <i class="fa-regular fa-envelope text-[#2ca7a3]"></i>
                            <span>legal@soxnsox.in</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-200">
                            <i class="fa-solid fa-phone text-[#f29a38]"></i>
                            <span>+91 81061 55111</span>
                        </div>
                    </div>
                    <a
                        href="{{ route('shop.home.contact_us') }}"
                        class="w-full text-center py-2.5 px-4 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2ca7a3] text-white hover:bg-[#238a87] transition-all block shadow-xs"
                    >
                        Contact Support Team
                    </a>
                </div>
            </aside>

            <!-- Right Content Column (8 cols) -->
            <div class="lg:col-span-8 space-y-8">

                <!-- SECTION 1: AGREEMENT & ELIGIBILITY -->
                <div id="section-1" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        01
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Agreement to Terms &amp; Eligibility
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        These Terms and Conditions of Sale ("Terms") constitute a legally binding agreement between you ("Customer," "you," or "user") and <strong class="text-[#133b63]">SOX N SOX</strong> (operated by Involute Institute of Industrial Training, Hyderabad, India, hereinafter referred to as "we," "us," or "our").
                    </p>
                    <p>
                        By visiting our website at <strong class="text-[#133b63]">soxnsox.in</strong>, browsing our footwear collections, registering an account, or placing an order, you confirm that:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>You are at least 18 years of age or possess legal parental or guardian authorization to purchase in your jurisdiction.</li>
                        <li>You have full legal capacity to enter into binding commercial contracts under the Indian Contract Act, 1872.</li>
                        <li>All information provided by you during registration or checkout (name, postal address, mobile number, payment details) is true, accurate, and current.</li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 2: MEDICAL DISCLAIMER (CRITICAL) -->
            <div id="section-2" class="bg-amber-50/60 rounded-3xl p-6 sm:p-10 border border-amber-200/80 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f29a38] text-white font-bold text-sm">
                        <i class="fa-solid fa-notes-medical text-sm"></i>
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Product Description &amp; Diabetic Footwear Medical Disclaimer
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-amber-950 leading-relaxed space-y-4 font-medium">
                    <p>
                        SOX N SOX specializes in manufacturing precision-engineered bamboo socks designed for everyday living, sports, and foot wellness. Our <strong class="text-[#133b63]">Diabetic &amp; Circulatory Comfort Socks</strong> are designed with non-binding wide-stretch top bands, zero-ridge hand-linked seamless toes, and cushioned terry soles that promote healthy leg circulation and protect sensitive feet from friction-induced blisters.
                    </p>
                    <div class="p-4 rounded-2xl bg-white border border-amber-200 text-xs sm:text-sm text-slate-700 space-y-2">
                        <p class="font-bold text-[#133b63] uppercase tracking-wider text-xs">Important Health &amp; Medical Clarification:</p>
                        <p>
                            SOX N SOX socks are categorized as <strong>comfort apparel and supportive daily wear</strong>. They are not intended, certified, or marketed as medical devices, prescription orthotics, or therapeutic drugs. They do not diagnose, treat, cure, or prevent any medical condition or metabolic disease, including diabetes mellitus, diabetic foot ulcers, peripheral neuropathy, or deep vein thrombosis (DVT).
                        </p>
                        <p>
                            If you suffer from active diabetic ulcers, severe peripheral arterial disease, neuropathy, open wounds, or chronic circulatory disorders, always consult your treating endocrinologist, podiatrist, or certified physician for specialized clinical footwear guidance.
                        </p>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: PRICING, TAXES & PAYMENTS -->
            <div id="section-3" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff4e8] text-[#f29a38] font-bold text-sm">
                        03
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Pricing, GST Taxes &amp; Secure Payments
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Indian Rupee (INR) Pricing:</strong> All prices displayed on our website are denominated in Indian National Rupees (INR) and are fully inclusive of Goods and Services Tax (GST) under applicable Indian tax laws.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Payment Modes:</strong> We accept all standard Indian payment options: Unified Payments Interface (UPI via Google Pay, PhonePe, Paytm, Cred, BHIM), RuPay, Visa, MasterCard, Net Banking across 50+ banks, and Cash on Delivery (COD).
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Security &amp; Encryption:</strong> Digital payments are processed through PCI-DSS Level 1 compliant Indian payment gateways. All card transactions require mandatory Reserve Bank of India Two-Factor Authentication (OTP). We do not record or retain card CVV numbers.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Pricing Accuracy:</strong> In the rare event of a technical typographical error resulting in an incorrect price displayed on our storefront, we reserve the right to decline or cancel the affected order and issue an immediate 100% refund.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 4: ORDER WORKFLOW & CANCELLATION -->
            <div id="section-4" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf2f8] text-[#1d5b8f] font-bold text-sm">
                        04
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Order Confirmation &amp; Cancellation Policy
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Order Placement &amp; Acknowledgement:</strong> Submission of an order generates an automated email and SMS acknowledgement. Contractual acceptance of the order is formalized when the order is physically packed and handed over to our carrier with an Air Waybill (AWB) number.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Customer Cancellation:</strong> You may cancel your order free of charge at any time <strong class="text-[#133b63]">before it is dispatched</strong> by contacting our support team via WhatsApp at <a href="https://wa.me/918106155111" class="text-[#1d5b8f] underline font-bold">+91 81061 55111</a> or emailing <a href="mailto:support@soxnsox.in" class="text-[#1d5b8f] underline font-bold">support@soxnsox.in</a> with your Order ID.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Post-Dispatch Orders:</strong> Once an order has been handed to our courier partner and a live tracking link is generated, it cannot be recalled in transit; however, you may utilize our 7-Day Exchange Policy upon delivery.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Cancellation by Merchant:</strong> We reserve the right to cancel orders in instances of unserviceable pin codes, non-responsive COD verification calls, or flagged fraudulent payment behavior.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 5: SHIPPING & DELIVERY -->
            <div id="section-5" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        05
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Shipping, Risk of Loss &amp; Title
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        Our shipping terms are detailed in our dedicated <a href="{{ route('shop.cms.page', 'shipping-policy') }}" class="text-[#1d5b8f] underline font-bold hover:text-[#133b63]">Shipping &amp; Delivery Policy</a>, summarized here:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Free Shipping:</strong> Automatically applied on all orders with a subtotal of <strong class="text-[#133b63]">₹499 or above</strong> across India. Orders below ₹499 incur a flat ₹50 express delivery fee.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Title &amp; Risk:</strong> Title and risk of loss for products pass to you upon delivery confirmation by the courier carrier at your specified destination address.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Inspection at Delivery:</strong> Please do not accept parcels that arrive with torn outer packaging, broken tamper seals, or non-brand adhesive tape.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 6: RETURNS & HYGIENE POLICY -->
            <div id="section-6" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff4e8] text-[#f29a38] font-bold text-sm">
                        06
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Returns, Replacements &amp; Footwear Hygiene Standard
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        We stand behind our craftsmanship with a <strong class="text-[#133b63]">7-Day Easy Exchange Policy</strong>:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Eligibility:</strong> Requests must be submitted within 7 calendar days of delivery for verified manufacturing defects, knit unraveling, transit damage, or incorrect size received.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Strict Hygiene Mandate:</strong> Socks are classified as intimate personal footwear apparel. Under consumer health and sanitary guidelines, socks that have been worn, laundered, tried on without inner packaging, or returned without original tags cannot be accepted.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Replacement Process:</strong> Contact us with photo proof. Our logistics team will arrange a reverse pickup within 24–48 hours, followed by expedited dispatch of your replacement pair.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 7: INTELLECTUAL PROPERTY -->
            <div id="section-7" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf2f8] text-[#1d5b8f] font-bold text-sm">
                        07
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Intellectual Property Rights
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        All content hosted on <strong class="text-[#133b63]">soxnsox.in</strong> — including brand trademarks, the SOX N SOX logo, typography, product photography, editorial writeups, knitting technical specifications, and user interface software — is the exclusive proprietary property of Involute Institute of Industrial Training and SOX N SOX.
                    </p>
                    <p>
                        No content may be downloaded, reproduced, copied, framed, scraped, or republished for commercial resale or external distribution without our prior written authorization.
                    </p>
                </div>
            </div>

            <!-- SECTION 8: LIMITATION OF LIABILITY -->
            <div id="section-8" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        08
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Limitation of Liability &amp; Disclaimers
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        To the maximum extent permitted under applicable Indian law:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            SOX N SOX provides this platform on an "as is" and "as available" basis without express or implied warranties of uninterrupted uptime or error-free web operation.
                        </li>
                        <li>
                            In no event shall SOX N SOX, its directors, partners, officers, or logistics affiliates be liable for indirect, incidental, punitive, or consequential damages resulting from website downtime or courier delays.
                        </li>
                        <li>
                            Our total aggregate monetary liability for any claim arising out of your purchase of products through our website shall be strictly capped at the actual amount paid by you for the specific product order giving rise to the claim.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 9: GOVERNING LAW & JURISDICTION -->
            <div id="section-9" class="rounded-3xl p-6 sm:p-10 bg-gradient-to-br from-[#133b63] to-[#0b1e32] text-white shadow-xl space-y-6 scroll-mt-28">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2ca7a3]/20 text-[#2ca7a3] border border-[#2ca7a3]/30">
                        <i class="fa-solid fa-gavel"></i> Legal Jurisdiction
                    </span>
                    <h2 class="font-display text-2xl sm:text-3xl font-extrabold mt-3">
                        Governing Law &amp; Dispute Resolution
                    </h2>
                    <p class="text-slate-300 text-sm mt-2 max-w-xl">
                        These Terms and all purchase transactions conducted through soxnsox.in are governed by and construed in accordance with the laws of the Republic of India.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 text-sm">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-[#2ca7a3] font-bold uppercase tracking-wider">Amicable Settlement</p>
                        <p class="font-semibold text-white">30-Day Resolution Desk</p>
                        <p class="text-[11px] text-slate-400">Direct escalation to senior management</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-[#f29a38] font-bold uppercase tracking-wider">Exclusive Court Jurisdiction</p>
                        <p class="font-semibold text-white">Hyderabad / Medchal</p>
                        <p class="text-[11px] text-slate-400">Courts of Telangana, India</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-teal-300 font-bold uppercase tracking-wider">Operating Entity</p>
                        <p class="font-semibold text-white">Involute Institute</p>
                        <p class="text-[11px] text-slate-400">ALEAP Industrial Estate, Hyderabad</p>
                    </div>
                </div>

                <div class="pt-2 flex flex-wrap gap-4">
                    <a
                        href="{{ route('shop.home.contact_us') }}"
                        class="px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider text-[#133b63] bg-white hover:bg-slate-100 transition-all shadow-md active:scale-95 inline-flex items-center gap-2"
                    >
                        <span>Contact Legal Desk</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a
                        href="{{ route('shop.cms.page', 'shipping-policy') }}"
                        class="px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider text-white bg-[#2ca7a3] hover:bg-[#238a87] transition-all shadow-md active:scale-95 inline-flex items-center gap-2"
                    >
                        <span>View Shipping Policy</span>
                        <i class="fa-solid fa-truck-fast text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

