<div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
    @if (core()->getConfigData('general.general.breadcrumbs.shop'))
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <span class="text-[#133b63] font-semibold">Privacy Policy</span>
            </nav>
        </div>
    @endif

    <!-- HERO SECTION -->
    <section class="site-container pt-8 pb-14 sm:pt-12 sm:pb-16 border-b border-slate-200">
        <div class="max-w-3xl mx-auto text-center space-y-5 mb-8">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold tracking-widest uppercase border border-[#2ca7a3]/25 shadow-xs">
                <i class="fa-solid fa-user-shield text-[#2ca7a3] text-sm"></i>
                <span>DPDP Act 2023 &bull; RBI &bull; 256-Bit SSL Protection</span>
            </div>

            <!-- Title -->
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#133b63] leading-[1.14]">
                Privacy Policy &amp; Data Protection
            </h1>

            <div class="soxnsox-decorative-line-center my-3"></div>

            <p class="text-base sm:text-lg leading-relaxed text-[#6b7280]">
                We believe trust is earned through complete transparency. Learn how SOX N SOX safeguards your personal information, protects your digital transactions, and guarantees total confidentiality.
            </p>

            <p class="text-xs text-slate-400 font-medium">
                Last Updated: October 2026 &bull; Compliant with Indian Information Technology &amp; Data Protection Laws
            </p>
        </div>

        <!-- 4 Security Guarantees (Full site-container width) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 pt-6 text-left reveal-stagger">
            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#2ca7a3]">100%</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Zero Data Sale</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">We never sell, trade, or monetize your contact details.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#1d5b8f]">256-Bit</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">SSL Encryption</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Military-grade protection across all pages and checkout.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#f29a38]">RBI Compliant</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Tokenized Pay</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">No raw card or CVV details stored on our servers.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all">
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-[#2ca7a3]">DPDP</p>
                <p class="text-xs uppercase tracking-wider text-[#133b63] font-bold mt-1">Full User Rights</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Access, correct, or request deletion of your profile anytime.</p>
            </div>
        </div>
    </section>

    <!-- MAIN PRIVACY CONTENT (Full site-container width with Sticky Sidebar Navigation) -->
    <section class="site-container py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Left Sticky Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
                <!-- Navigation Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                        <i class="fa-solid fa-bars-staggered"></i>
                        <span>Policy Navigation</span>
                    </div>
                    <nav class="space-y-1 text-xs sm:text-sm font-medium">
                        <a href="#section-1" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">01</span>
                            <span>Introduction &amp; Scope</span>
                        </a>
                        <a href="#section-2" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">02</span>
                            <span>Information We Collect</span>
                        </a>
                        <a href="#section-3" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#1d5b8f]">03</span>
                            <span>How We Collect Data</span>
                        </a>
                        <a href="#section-4" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">04</span>
                            <span>Purposes of Processing</span>
                        </a>
                        <a href="#section-5" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">05</span>
                            <span>Strict Non-Sale of Data</span>
                        </a>
                        <a href="#section-6" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#1d5b8f]">06</span>
                            <span>Third-Party Sharing</span>
                        </a>
                        <a href="#section-7" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">07</span>
                            <span>Cookies &amp; Tracking</span>
                        </a>
                        <a href="#section-8" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#f29a38]">08</span>
                            <span>Security &amp; Retention</span>
                        </a>
                        <a href="#section-9" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#1d5b8f]">09</span>
                            <span>DPDP User Rights</span>
                        </a>
                        <a href="#section-10" class="flex items-center gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors">
                            <span class="text-[11px] font-bold text-[#2ca7a3]">10</span>
                            <span>Grievance Officer</span>
                        </a>
                    </nav>
                </div>

                <!-- Direct Help Card -->
                <div class="bg-gradient-to-br from-[#133b63] to-[#0c243d] rounded-3xl p-6 text-white shadow-md space-y-4">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                        <i class="fa-solid fa-headset"></i>
                        <span>Need Data Assistance?</span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Have questions about your data privacy or want to exercise your rights under the DPDP Act?
                    </p>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center gap-2 text-slate-200">
                            <i class="fa-regular fa-envelope text-[#2ca7a3]"></i>
                            <span>privacy@soxnsox.in</span>
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

                <!-- SECTION 1: INTRODUCTION -->
                <div id="section-1" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        01
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Introduction &amp; Scope
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        This Privacy Policy explains how <strong class="text-[#133b63]">SOX N SOX</strong> ("we," "our," "us"), operating under Involute Institute of Industrial Training, collects, uses, protects, and discloses personal data when you visit <strong class="text-[#133b63]">soxnsox.in</strong>, purchase our bamboo and diabetic socks, create an account, or contact our customer support team.
                    </p>
                    <p>
                        We operate in strict adherence to the <strong class="text-[#133b63]">Digital Personal Data Protection Act, 2023 (DPDP Act)</strong>, the <strong class="text-[#133b63]">Information Technology Act, 2000</strong>, the Information Technology (Reasonable Security Practices and Procedures and Sensitive Personal Data or Information) Rules, 2011, and the Reserve Bank of India (RBI) payment security directives.
                    </p>
                    <p>
                        By visiting our website or submitting personal data, you acknowledge and consent to the practices described in this policy.
                    </p>
                </div>
            </div>

            <!-- SECTION 2: INFORMATION WE COLLECT -->
            <div id="section-2" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff4e8] text-[#f29a38] font-bold text-sm">
                        02
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Information We Collect
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        We collect only the minimum necessary data required to process orders, facilitate doorstep delivery, and provide personalized customer assistance:
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div class="p-5 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-2">
                            <span class="font-bold text-sm text-[#133b63] flex items-center gap-2">
                                <i class="fa-solid fa-address-card text-[#2ca7a3]"></i>
                                Identity &amp; Contact Details
                            </span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Full name, billing address, doorstep shipping address, email address, active 10-digit mobile number, and recipient contact details for delivery.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-2">
                            <span class="font-bold text-sm text-[#133b63] flex items-center gap-2">
                                <i class="fa-solid fa-receipt text-[#f29a38]"></i>
                                Order &amp; Transaction Data
                            </span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Sock styles purchased, pack size, shoe sizes selected, total amount paid, invoice numbers, delivery tracking identifiers, and return/exchange records.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-2">
                            <span class="font-bold text-sm text-[#133b63] flex items-center gap-2">
                                <i class="fa-solid fa-credit-card text-[#1d5b8f]"></i>
                                Payment Credentials (Tokenized)
                            </span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Handled exclusively by PCI-DSS Level 1 certified gateways. We only store payment method type (e.g. UPI, Net Banking, COD) and transaction status — never credit/debit card numbers or CVV.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-2">
                            <span class="font-bold text-sm text-[#133b63] flex items-center gap-2">
                                <i class="fa-solid fa-laptop-code text-[#2ca7a3]"></i>
                                Technical &amp; Device Information
                            </span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Internet Protocol (IP) address, browser type and version, device operating system, session cookies, and basic referral data to optimize storefront performance.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: HOW WE COLLECT YOUR DATA -->
            <div id="section-3" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf2f8] text-[#1d5b8f] font-bold text-sm">
                        03
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        How We Collect Your Information
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Directly From You:</strong> When you register an account, checkout as a guest, submit an inquiry through our Contact Us form, write a verified customer review, or subscribe to our Sock Club newsletter.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Automated Website Technologies:</strong> As you navigate soxnsox.in, standard web servers and secure cookies log browsing sessions to preserve your shopping cart, maintain security tokens, and analyze page load speeds.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Logistics &amp; Payment Service Providers:</strong> Our integrated courier networks (Blue Dart, Delhivery) update us with package delivery milestones, and payment gateways confirm transaction settlement tokens.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 4: PURPOSES OF PROCESSING -->
            <div id="section-4" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        04
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Purposes for Which We Use Your Data
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        Your personal information is used strictly for legitimate commercial and operational purposes:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Order Fulfillment &amp; Dispatch:</strong> Processing payments, preparing shipping labels, packing socks, and executing doorstep delivery via our courier partners.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Real-Time Notifications:</strong> Transmitting order confirmation receipts, GST invoices, and AWB dispatch tracking links via SMS, WhatsApp, and email.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Customer Care &amp; Warranty Assistance:</strong> Assisting you with sizing recommendations, diabetic foot comfort inquiries, replacement scheduling, or return authorizations.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Fraud Detection &amp; Security:</strong> Verifying Cash on Delivery orders, verifying billing credentials, and safeguarding our web servers against malicious bot attacks.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Statutory Tax &amp; Legal Compliance:</strong> Complying with Indian Goods and Services Tax (GST) invoicing requirements, accounting auditing, and regulatory mandates.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 5: STRICT NON-SALE OF DATA -->
            <div id="section-5" class="bg-gradient-to-r from-teal-50 to-emerald-50 rounded-3xl p-6 sm:p-10 border border-teal-200 shadow-sm space-y-4 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#2ca7a3] text-white font-bold text-sm">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Our Strict Guarantee: We Never Sell Your Data
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-teal-950 leading-relaxed space-y-3 font-medium">
                    <p>
                        SOX N SOX maintains a categorical, uncompromising commitment: <strong class="text-[#133b63]">We do not sell, rent, monetize, broker, or trade your personal information, mobile numbers, or email addresses to any third-party advertisers, data aggregators, or telemarketers.</strong>
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600">
                        Your contact data is used solely to facilitate your relationship with SOX N SOX. You will never receive unsolicited third-party promotional calls or spam as a result of shopping with us.
                    </p>
                </div>
            </div>

            <!-- SECTION 6: AUTHORIZED THIRD-PARTY SHARING -->
            <div id="section-6" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff4e8] text-[#f29a38] font-bold text-sm">
                        06
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Essential Third-Party Service Providers
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        We disclose necessary personal information strictly to vetted operational partners bound by confidentiality and security covenants:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Logistics &amp; Courier Partners:</strong> Blue Dart Express, Delhivery, Xpressbees, and DTDC receive your name, shipping address, and mobile number solely to execute package delivery and contact you upon doorstep arrival.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Payment Gateway Operators:</strong> RBI-licensed entities (such as Razorpay, Cashfree, and affiliated Indian banking networks) process financial payments through encrypted, tokenized channels.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Communication Infrastructure:</strong> Telecom partners and SMS gateways authorized under TRAI regulations to transmit transactional OTPs, order updates, and dispatch tracking links.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Legal &amp; Regulatory Authorities:</strong> We may disclose data when strictly mandated by Indian law, judicial summons, or to comply with statutory tax investigations.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 7: COOKIES & TRACKING -->
            <div id="section-7" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf2f8] text-[#1d5b8f] font-bold text-sm">
                        07
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Cookies &amp; Local Storage Policy
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        Cookies are small data files placed on your device to ensure smooth website operation:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">Essential Session Cookies:</strong> Required to keep items in your shopping cart, authenticate user logins, and enforce Cross-Site Request Forgery (CSRF) security.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Preference Cookies:</strong> Remember your preferred currency (INR), locale (English), and display settings for future visits.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Analytics Cookies:</strong> Help us understand aggregate visitor flows and popular sock categories to continuously optimize user experience.
                        </li>
                    </ul>
                    <p class="text-xs text-slate-500 pt-2">
                        You can manage, restrict, or delete cookies via your browser settings (Chrome, Safari, Firefox, Edge). Note that disabling essential session cookies may prevent items from persisting in your cart or impede checkout completion.
                    </p>
                </div>
            </div>

            <!-- SECTION 8: DATA SECURITY & RETENTION -->
            <div id="section-8" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] font-bold text-sm">
                        08
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Data Security &amp; Retention Standards
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        We enforce multi-tiered administrative, technical, and physical safeguards:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                        <li>
                            <strong class="text-[#133b63]">End-to-End Encryption:</strong> All data transmitted between your web browser and our servers is encrypted using modern 256-bit Secure Sockets Layer (SSL/TLS 1.3).
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Restricted Database Access:</strong> Customer records are stored in hardened database instances protected by firewalls, with access restricted strictly to authorized operations personnel.
                        </li>
                        <li>
                            <strong class="text-[#133b63]">Retention Schedules:</strong> We retain order records and GST tax invoices for <strong class="text-[#133b63]">7 years</strong> in compliance with the Indian Companies Act and Goods and Services Tax Act. Routine temporary session data is expunged on an ongoing basis.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SECTION 9: YOUR RIGHTS UNDER DPDP ACT -->
            <div id="section-9" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-5 scroll-mt-28">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff4e8] text-[#f29a38] font-bold text-sm">
                        09
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-[#133b63]">
                        Your Data Rights (DPDP Act, 2023)
                    </h2>
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>
                        As a Data Principal under Indian law, you possess explicit rights regarding your personal information:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-4 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-1">
                            <span class="font-bold text-xs uppercase tracking-wider text-[#133b63]">Right to Access &amp; Summary</span>
                            <p class="text-xs text-slate-500">Request a complete summary of personal data held about you and processing activities undertaken.</p>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-1">
                            <span class="font-bold text-xs uppercase tracking-wider text-[#133b63]">Right to Correction &amp; Update</span>
                            <p class="text-xs text-slate-500">Correct any inaccurate address, outdated phone number, or incomplete account information.</p>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-1">
                            <span class="font-bold text-xs uppercase tracking-wider text-[#133b63]">Right to Erasure ("Be Forgotten")</span>
                            <p class="text-xs text-slate-500">Request deletion of your customer profile, subject to statutory tax record retention obligations.</p>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-200 bg-[#f8fafc] space-y-1">
                            <span class="font-bold text-xs uppercase tracking-wider text-[#133b63]">Right to Opt-Out &amp; Unsubscribe</span>
                            <p class="text-xs text-slate-500">Opt out of promotional emails and announcements with a single click at any time.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 10: GRIEVANCE REDRESSAL OFFICER -->
            <div id="section-10" class="rounded-3xl p-6 sm:p-10 bg-gradient-to-br from-[#133b63] to-[#0b1e32] text-white shadow-xl space-y-6 scroll-mt-28">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2ca7a3]/20 text-[#2ca7a3] border border-[#2ca7a3]/30">
                        <i class="fa-solid fa-scale-balanced"></i> Statutory Compliance
                    </span>
                    <h2 class="font-display text-2xl sm:text-3xl font-extrabold mt-3">
                        Grievance Redressal Officer
                    </h2>
                    <p class="text-slate-300 text-sm mt-2 max-w-xl">
                        In accordance with the Information Technology Act, 2000 and the Digital Personal Data Protection Act, 2023, the details of our designated Grievance Officer are published below:
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 text-sm">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-[#2ca7a3] font-bold uppercase tracking-wider">Designated Officer</p>
                        <p class="font-semibold text-white">Grievance &amp; Privacy Officer</p>
                        <p class="text-[11px] text-slate-400">Involute Institute of Industrial Training</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-[#f29a38] font-bold uppercase tracking-wider">Email Correspondence</p>
                        <p class="font-semibold text-white">privacy@soxnsox.in</p>
                        <p class="text-[11px] text-slate-400">Acknowledged within 48 hours</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                        <p class="text-xs text-teal-300 font-bold uppercase tracking-wider">Registered Corporate Address</p>
                        <p class="font-semibold text-white">ALEAP Industrial Estate</p>
                        <p class="text-[11px] text-slate-400">Gajularamaram, Hyderabad - 500090, Telangana</p>
                    </div>
                </div>

                <div class="pt-2 flex flex-wrap gap-4">
                    <a
                        href="mailto:privacy@soxnsox.in"
                        class="px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider text-[#133b63] bg-white hover:bg-slate-100 transition-all shadow-md active:scale-95 inline-flex items-center gap-2"
                    >
                        <span>Submit Data Request</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a
                        href="{{ route('shop.home.contact_us') }}"
                        class="px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider text-white bg-[#2ca7a3] hover:bg-[#238a87] transition-all shadow-md active:scale-95 inline-flex items-center gap-2"
                    >
                        <span>Customer Support Helpdesk</span>
                        <i class="fa-solid fa-headset text-xs"></i>
                    </a>
                </div>
            </div>

        </div>
        </div>
    </section>
</div>
