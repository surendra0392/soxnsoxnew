<!-- Page Layout -->
<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        Contact SOX N SOX | Bamboo &amp; Diabetic Socks Customer Care
    </x-slot>

    @inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

    @php
        $channel = core()->getCurrentChannel();
        $contactEmail = core()->getConfigData('emails.configure.email_settings.contact_email') ?: 'support@soxnsox.in';
        $adminEmail = core()->getConfigData('emails.configure.email_settings.admin_email') ?: 'sales@soxnsox.in';
        $address = core()->getConfigData('sales.shipping.origin.address') ?: (core()->getConfigData('sales.shipping.origin.address1') ?: 'Involute Institute of Industrial Training, Shed No 1,Survy No342, ALEAP Industrial Estate, Gajularamaram, Road Number 10, Pragathi Nagar');
        $city = core()->getConfigData('sales.shipping.origin.city') ?: 'Hyderabad, Medchal Malkajgiri';
        $state = core()->getConfigData('sales.shipping.origin.state') ?: 'Telangana';
        $zipcode = core()->getConfigData('sales.shipping.origin.zipcode') ?: '500090';
        $country = core()->getConfigData('sales.shipping.origin.country') === 'IN' ? 'India' : (core()->getConfigData('sales.shipping.origin.country') ?: 'India');

        $customization = $themeCustomizationRepository->findOneWhere([
            'type'       => 'footer_links',
            'status'     => 1,
            'theme_code' => $channel->theme,
            'channel_id' => $channel->id,
        ]);

        $socialLinks = $customization->options['social_links'] ?? [
            'instagram' => 'https://instagram.com/soxnsox',
            'facebook'  => 'https://facebook.com/soxnsox',
            'twitter'   => 'https://twitter.com/soxnsox',
        ];
    @endphp

    @push('meta')
        <meta name="title" content="Contact SOX N SOX | Bamboo &amp; Diabetic Socks Customer Support" />
        <meta name="description" content="Reach out to the SOX N SOX footcare team for sizing guidance, diabetic footcare recommendations, order tracking, and wholesale inquiries." />
        <meta name="keywords" content="contact soxnsox, diabetic socks support, bamboo socks customer care, soxnsox wholesale, socks helpline" />
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
        <link rel="canonical" href="{{ route('shop.home.contact_us') }}" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Contact SOX N SOX | Bamboo &amp; Diabetic Socks Customer Support" />
        <meta name="twitter:description" content="Reach out to the SOX N SOX footcare team for sizing guidance, diabetic footcare recommendations, order tracking, and wholesale inquiries." />

        <meta property="og:type" content="website" />
        <meta property="og:title" content="Contact SOX N SOX | Bamboo &amp; Diabetic Socks Customer Support" />
        <meta property="og:description" content="Reach out to the SOX N SOX footcare team for sizing guidance, diabetic footcare recommendations, order tracking, and wholesale inquiries." />
        <meta property="og:url" content="{{ route('shop.home.contact_us') }}" />

        <!-- JSON-LD ContactPage & FAQPage Schema -->
        @php
            $contactSchema = [
                '@context' => 'https://schema.org',
                '@graph'   => [
                    [
                        '@type'       => 'ContactPage',
                        '@id'         => route('shop.home.contact_us') . '/#contactpage',
                        'url'         => route('shop.home.contact_us'),
                        'name'        => 'Contact SOX N SOX Customer Care',
                        'description' => 'Connect with the SOX N SOX foot health team for sizing guidance, diabetic sock queries, orders, and bulk corporate partnerships.',
                        'mainEntity'  => [
                            '@type'     => 'Organization',
                            'name'      => 'SOX N SOX',
                            'telephone' => '+91-81061-55111',
                            'email'     => $contactEmail,
                            'address'   => [
                                '@type'           => 'PostalAddress',
                                'streetAddress'   => $address,
                                'addressLocality' => $city,
                                'addressRegion'   => $state,
                                'postalCode'      => $zipcode,
                                'addressCountry'  => $country,
                            ],
                        ],
                    ],
                    [
                        '@type'      => 'FAQPage',
                        '@id'        => route('shop.home.contact_us') . '/#faq',
                        'mainEntity' => [
                            [
                                '@type'          => 'Question',
                                'name'           => 'How do I choose the correct sock size?',
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text'  => 'SOX N SOX socks feature premium 4-way elastic stretch woven with elastane that fits men and women comfortably across shoe sizes UK/India 6 to 11.',
                                ],
                            ],
                            [
                                '@type'          => 'Question',
                                'name'           => 'What makes SOX N SOX diabetic socks therapeutic?',
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text'  => 'Our diabetic socks feature non-binding soft grip cuffs that never leave elastic ring marks, seamless hand-linked toes that prevent friction blisters, and antimicrobial bamboo yarn.',
                                ],
                            ],
                            [
                                '@type'          => 'Question',
                                'name'           => 'How should I wash and care for bamboo socks?',
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text'  => 'Machine wash cold on gentle cycle or hand wash with mild detergent. Tumble dry on low or line dry in the shade. Do not bleach or iron.',
                                ],
                            ],
                            [
                                '@type'          => 'Question',
                                'name'           => 'What are your delivery timelines across India?',
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text'  => 'Orders placed before 2:00 PM IST Monday to Saturday are dispatched within 24 hours. Air express delivery takes 2–4 business days in major metros and 3–5 days for other pin codes.',
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        @endphp
        <script type="application/ld+json">
        {!! json_encode($contactSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endPush

    @push('styles')
        <style>
            .quick-pick-chip {
                display: inline-flex;
                align-items: center;
                padding: 0.3rem 0.75rem;
                border-radius: 9999px;
                font-size: 11px;
                font-weight: 600;
                line-height: 1.25rem;
                cursor: pointer;
                transition: all 0.2s ease-in-out;
                user-select: none;
            }
            .quick-pick-chip.chip-diabetic {
                background-color: #e6f8f7 !important;
                color: #2ca7a3 !important;
                border: 1px solid rgba(44, 167, 163, 0.35) !important;
            }
            .quick-pick-chip.chip-diabetic:hover {
                background-color: #2ca7a3 !important;
                color: #ffffff !important;
                border-color: #2ca7a3 !important;
            }
            .quick-pick-chip.chip-bamboo {
                background-color: #fff4e8 !important;
                color: #f29a38 !important;
                border: 1px solid rgba(242, 154, 56, 0.35) !important;
            }
            .quick-pick-chip.chip-bamboo:hover {
                background-color: #f29a38 !important;
                color: #ffffff !important;
                border-color: #f29a38 !important;
            }
            .quick-pick-chip.chip-order {
                background-color: #e9f2fa !important;
                color: #1d5b8f !important;
                border: 1px solid rgba(29, 91, 143, 0.35) !important;
            }
            .quick-pick-chip.chip-order:hover {
                background-color: #1d5b8f !important;
                color: #ffffff !important;
                border-color: #1d5b8f !important;
            }
            .quick-pick-chip.chip-wholesale {
                background-color: #f1f5f9 !important;
                color: #133b63 !important;
                border: 1px solid rgba(19, 59, 99, 0.25) !important;
            }
            .quick-pick-chip.chip-wholesale:hover {
                background-color: #133b63 !important;
                color: #ffffff !important;
                border-color: #133b63 !important;
            }
        </style>
    @endpush

    <div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
        @if (core()->getConfigData('general.general.breadcrumbs.shop'))
            <!-- Breadcrumbs Navigation -->
            <div class="site-container pt-5 pb-2 sm:pt-7 sm:pb-3">
                <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.18em] text-[#6b7280]">
                    <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                    <span class="text-slate-300">/</span>
                    <span class="text-[#133b63] font-semibold">Contact Us</span>
                </nav>
            </div>
        @endif

        <!-- SECTION 1: HERO & HEADER WITH FEATURED VISUAL -->
        <section class="site-container pt-6 pb-12 sm:pt-10 sm:pb-16 border-b border-slate-200">
            <div class="max-w-3xl mx-auto text-center space-y-5 mb-8">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold tracking-[0.2em] uppercase border border-[#2ca7a3]/25 shadow-xs">
                    <i class="fa-solid fa-headset text-sm"></i>
                    <span>We Would Love To Hear From You</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#133b63] leading-[1.15]">
                    Contact Us <br class="hidden sm:inline">
                    <span class="text-[#f29a38] text-2xl sm:text-4xl lg:text-5xl font-bold block mt-2">We're Here For Your Everyday Comfort.</span>
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-[#6b7280] leading-relaxed">
                    Have questions about sizing, diabetic footcare features, bamboo fibers, wholesale orders, or delivery status? Our dedicated care team is here to assist.
                </p>
            </div>

            <!-- Featured Lifestyle Visual Banner (Full site-container width) -->
            <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-slate-900 group">
                    <img
                        src="{{ asset('images/about/everyday-comfort-relax.png') }}"
                        alt="SOX N SOX Dedicated Customer Care & Everyday Foot Comfort"
                        class="w-full h-72 sm:h-96 lg:h-[420px] object-cover object-center transition-transform duration-700 group-hover:scale-105 opacity-95"
                        loading="eager"
                    />
                    
                    <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-10 text-left" style="background: linear-gradient(to top, rgba(19, 59, 99, 0.95) 0%, rgba(19, 59, 99, 0.6) 50%, rgba(19, 59, 99, 0) 100%);">
                        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 mb-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #2ca7a3;">
                                <i class="fa-solid fa-phone text-xs"></i> Direct Line: +91 81061 55111
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #f29a38;">
                                <i class="fa-brands fa-whatsapp text-xs"></i> WhatsApp Assistance
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #1d5b8f;">
                                <i class="fa-solid fa-clock text-xs"></i> 24h Response SLA
                            </span>
                        </div>
                        <p class="text-white text-sm sm:text-base font-semibold max-w-xl drop-shadow-sm">
                            Connect directly with our customer desk in Hyderabad. Speak with real product specialists passionate about foot wellness.
                        </p>
                    </div>
                </div>

                <!-- Quick SLA Highlight Strip -->
                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-6 pt-2 text-xs font-bold uppercase tracking-wider text-[#133b63]">
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 shadow-xs">
                        <i class="fa-solid fa-clock text-xs text-[#f29a38]"></i>
                        <span>24h Response SLA</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 shadow-xs">
                        <i class="fa-solid fa-circle-check text-xs text-[#2ca7a3]"></i>
                        <span>Doctor-Approved Fit</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 shadow-xs">
                        <i class="fa-solid fa-truck text-xs text-[#1d5b8f]"></i>
                        <span>Pan-India Dispatch</span>
                    </div>
                </div>
        </section>

        <!-- SECTION 2: MAIN CONTACT EXPERIENCE -->
        <main class="site-container py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                
                <!-- Left Column: Detailed Contact Cards & Visual Facility Badge (5 Columns) -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <!-- Direct Email Support Card -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-4 hover:border-[#2ca7a3]/50 transition-all">
                        <div class="flex items-center gap-3.5">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] shrink-0">
                                <i class="fa-regular fa-envelope text-lg"></i>
                            </span>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#2ca7a3]">Direct Email</span>
                                <h3 class="text-lg font-bold text-[#133b63]">Customer &amp; Order Care</h3>
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                            For order tracking, size consultations, returns, or diabetic sock inquiries:
                        </p>

                        <div class="space-y-2 pt-1 border-t border-slate-100">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                <span class="text-xs text-[#6b7280]">Customer Care:</span>
                                <a href="mailto:{{ $contactEmail }}" class="text-xs sm:text-sm font-bold text-[#1d5b8f] hover:text-[#133b63] hover:underline flex items-center gap-1">
                                    <span>{{ $contactEmail }}</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                <span class="text-xs text-[#6b7280]">Wholesale &amp; Retail:</span>
                                <a href="mailto:{{ $adminEmail }}" class="text-xs sm:text-sm font-bold text-[#f29a38] hover:text-[#e08927] hover:underline flex items-center gap-1">
                                    <span>{{ $adminEmail }}</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>

                        <div class="pt-2 text-[11px] text-[#6b7280] flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-xs text-[#2ca7a3]"></i>
                            <span>Dedicated support response within 24 business hours.</span>
                        </div>
                    </div>

                    <!-- Phone & WhatsApp Hotline Card -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-4 hover:border-[#2ca7a3]/50 transition-all">
                        <div class="flex items-center gap-3.5">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3] shrink-0">
                                <i class="fa-solid fa-phone text-lg"></i>
                            </span>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#f29a38]">Direct Helpline</span>
                                <h3 class="text-lg font-bold text-[#133b63]">+91 81061 55111</h3>
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                            Connect directly with our customer desk Monday through Saturday, 9:00 AM – 6:30 PM IST.
                        </p>

                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <a
                                href="https://wa.me/918106155111"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#25D366]/10 text-[#128C7E] text-xs font-bold hover:bg-[#25D366] hover:text-white transition-all shadow-xs"
                            >
                                <i class="fa-brands fa-whatsapp text-base"></i>
                                <span>WhatsApp</span>
                            </a>
                            <a
                                href="tel:+918106155111"
                                class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-[#133b63] text-xs font-bold hover:border-[#133b63] hover:text-[#133b63] transition-all shadow-xs"
                            >
                                <i class="fa-solid fa-phone text-sm"></i>
                                <span>Call Direct</span>
                            </a>
                        </div>
                    </div>

                    <!-- Dispatch & Headquarters Card -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-4 hover:border-[#2ca7a3]/50 transition-all">
                        <div class="flex items-center gap-3.5">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e9f2fa] text-[#1d5b8f] shrink-0">
                                <i class="fa-solid fa-location-dot text-lg"></i>
                            </span>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#1d5b8f]">Fulfillment Center</span>
                                <h3 class="text-lg font-bold text-[#133b63]">SOX N SOX Headquarters</h3>
                            </div>
                        </div>

                        <div class="text-xs sm:text-sm text-[#6b7280] leading-relaxed space-y-1">
                            <p class="font-bold text-[#133b63]">{{ $address }}</p>
                            <p>{{ $city }}, {{ $state }} - {{ $zipcode }}, {{ $country }}</p>
                        </div>

                        <div class="pt-2 text-[11px] text-[#6b7280] flex items-center gap-1.5 border-t border-slate-100">
                            <i class="fa-solid fa-shield-halved text-xs text-[#2ca7a3]"></i>
                            <span>Hygienic dust-free packaging &amp; express dispatch facility.</span>
                        </div>
                    </div>

                    <!-- Manufacturing & Craftsmanship Visual Card -->
                    <div class="rounded-2xl border border-slate-200 overflow-hidden shadow-sm bg-white">
                        <div class="relative h-44 overflow-hidden bg-slate-100">
                            <img
                                src="{{ asset('images/about/bamboo-craftsmanship.png') }}"
                                alt="Classic Knitters Hyderabad Manufacturing Hub"
                                class="w-full h-full object-cover object-center"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#133b63]/85 to-transparent flex items-end p-4">
                                <span class="text-xs font-bold text-white uppercase tracking-wider">
                                    Classic Knitters Pvt. Ltd. &bull; Hyderabad Hub
                                </span>
                            </div>
                        </div>
                        <div class="p-4 text-xs text-[#6b7280] leading-relaxed">
                            Home to our 200-needle medical knitting machinery and temperature-controlled finished goods storage.
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Inquiry Form (7 Columns) -->
                <div class="lg:col-span-7">
                    <div class="rounded-3xl border border-slate-200 bg-white p-7 sm:p-10 lg:p-12 shadow-sm space-y-6">
                        
                        <!-- Form Title Header -->
                        <div class="space-y-1.5 border-b border-slate-100 pb-5">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f29a38]">Send an Inquiry</span>
                            <h2 class="text-2xl sm:text-3xl font-bold text-[#133b63]">
                                How Can We Help You?
                            </h2>
                            <p class="text-xs sm:text-sm text-[#6b7280]">
                                Fill in your details below and a SOX N SOX specialist will get back to you promptly.
                            </p>
                        </div>

                        <!-- Session Notifications -->
                        @if (session('success'))
                            <div class="p-4 rounded-xl bg-[#e6f8f7] border border-[#2ca7a3]/30 text-[#2ca7a3] text-xs sm:text-sm font-medium flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-base"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm font-medium flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-exclamation text-base"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        <!-- Form -->
                        <x-shop::form :action="route('shop.home.contact_us.send_mail')">
                            
                            <!-- Full Name -->
                            <x-shop::form.control-group class="mb-4">
                                <x-shop::form.control-group.label class="required text-xs uppercase tracking-wider font-bold text-[#133b63] mb-1.5 block">
                                    Your Full Name
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] placeholder-[#6b7280]/60 focus:border-[#2ca7a3] focus:ring-2 focus:ring-[#2ca7a3]/20 transition-all outline-none"
                                    name="name"
                                    rules="required"
                                    :value="old('name')"
                                    label="Full Name"
                                    placeholder="e.g. Rahul Sharma"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="name" class="mt-1 text-xs text-red-600" />
                            </x-shop::form.control-group>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <!-- Email Address -->
                                <x-shop::form.control-group>
                                    <x-shop::form.control-group.label class="required text-xs uppercase tracking-wider font-bold text-[#133b63] mb-1.5 block">
                                        Email Address
                                    </x-shop::form.control-group.label>

                                    <x-shop::form.control-group.control
                                        type="email"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] placeholder-[#6b7280]/60 focus:border-[#2ca7a3] focus:ring-2 focus:ring-[#2ca7a3]/20 transition-all outline-none"
                                        name="email"
                                        rules="required|email"
                                        :value="old('email')"
                                        label="Email"
                                        placeholder="yourname@domain.com"
                                        aria-required="true"
                                    />

                                    <x-shop::form.control-group.error control-name="email" class="mt-1 text-xs text-red-600" />
                                </x-shop::form.control-group>

                                <!-- Phone / WhatsApp -->
                                <x-shop::form.control-group>
                                    <x-shop::form.control-group.label class="text-xs uppercase tracking-wider font-bold text-[#133b63] mb-1.5 block">
                                        Phone / WhatsApp <span class="text-[#6b7280] font-normal lowercase">(optional)</span>
                                    </x-shop::form.control-group.label>

                                    <x-shop::form.control-group.control
                                        type="text"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] placeholder-[#6b7280]/60 focus:border-[#2ca7a3] focus:ring-2 focus:ring-[#2ca7a3]/20 transition-all outline-none"
                                        name="contact"
                                        rules="phone"
                                        :value="old('contact')"
                                        label="Phone Number"
                                        placeholder="+91 81061 55111"
                                    />

                                    <x-shop::form.control-group.error control-name="contact" class="mt-1 text-xs text-red-600" />
                                </x-shop::form.control-group>
                            </div>

                            <!-- What Are You Looking For? -->
                            <x-shop::form.control-group class="mb-4">
                                <x-shop::form.control-group.label class="required text-xs uppercase tracking-wider font-bold text-[#133b63] mb-1.5 block">
                                    What Are You Looking For?
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="select"
                                    id="looking_for"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] focus:border-[#2ca7a3] focus:ring-2 focus:ring-[#2ca7a3]/20 transition-all outline-none cursor-pointer"
                                    name="looking_for"
                                    rules="required"
                                    label="What are you looking for"
                                    aria-required="true"
                                >
                                    <option value="" disabled selected>Please select what you are looking for...</option>
                                    <option value="Diabetic & Medical Socks">Diabetic &amp; Medical Socks (Non-Binding / Sensitive Foot)</option>
                                    <option value="Everyday Bamboo Socks">Everyday Bamboo Socks (Ankle / Crew / Dress)</option>
                                    <option value="Active & Sports Performance Socks">Active &amp; Sports Performance Socks (Cushioned Running)</option>
                                    <option value="Size & Fit Recommendation">Size &amp; Fit Recommendation</option>
                                    <option value="Order Tracking & Shipping Status">Order Tracking &amp; Shipping Status</option>
                                    <option value="Wholesale & Corporate Gifting">Wholesale, Bulk &amp; Corporate Gifting</option>
                                    <option value="Returns, Exchanges & Quality Support">Returns, Exchanges &amp; Quality Support</option>
                                    <option value="General Inquiry & Other">General Inquiry &amp; Other</option>
                                </x-shop::form.control-group.control>

                                <!-- Quick Topic Suggestion Pills -->
                                <div class="flex flex-wrap items-center gap-2 pt-2.5">
                                    <span class="text-[11px] text-[#6b7280] font-medium">Quick pick:</span>
                                    <button
                                        type="button"
                                        onclick="const el=document.getElementById('looking_for'); if(el){el.value='Diabetic & Medical Socks'; el.dispatchEvent(new Event('input', {bubbles:true})); el.dispatchEvent(new Event('change', {bubbles:true}));}"
                                        class="quick-pick-chip chip-diabetic"
                                    >
                                        Diabetic Socks
                                    </button>
                                    <button
                                        type="button"
                                        onclick="const el=document.getElementById('looking_for'); if(el){el.value='Everyday Bamboo Socks'; el.dispatchEvent(new Event('input', {bubbles:true})); el.dispatchEvent(new Event('change', {bubbles:true}));}"
                                        class="quick-pick-chip chip-bamboo"
                                    >
                                        Everyday Bamboo
                                    </button>
                                    <button
                                        type="button"
                                        onclick="const el=document.getElementById('looking_for'); if(el){el.value='Order Tracking & Shipping Status'; el.dispatchEvent(new Event('input', {bubbles:true})); el.dispatchEvent(new Event('change', {bubbles:true}));}"
                                        class="quick-pick-chip chip-order"
                                    >
                                        Order Status
                                    </button>
                                    <button
                                        type="button"
                                        onclick="const el=document.getElementById('looking_for'); if(el){el.value='Wholesale & Corporate Gifting'; el.dispatchEvent(new Event('input', {bubbles:true})); el.dispatchEvent(new Event('change', {bubbles:true}));}"
                                        class="quick-pick-chip chip-wholesale"
                                    >
                                        Wholesale / Bulk
                                    </button>
                                </div>

                                <x-shop::form.control-group.error control-name="looking_for" class="mt-1 text-xs text-red-600" />
                            </x-shop::form.control-group>

                            <!-- Message Content -->
                            <x-shop::form.control-group class="mb-5 !mt-7" style="margin-top: 1.75rem;">
                                <x-shop::form.control-group.label class="required text-xs uppercase tracking-wider font-bold text-[#133b63] mb-1.5 block">
                                    Your Message / Inquiry Details
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="textarea"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] placeholder-[#6b7280]/60 focus:border-[#2ca7a3] focus:ring-2 focus:ring-[#2ca7a3]/20 transition-all outline-none"
                                    name="message"
                                    rules="required"
                                    label="Message"
                                    placeholder="Please share details regarding your order, size advice, diabetic socks query, or wholesale requirement..."
                                    aria-required="true"
                                    rows="5"
                                />

                                <x-shop::form.control-group.error control-name="message" class="mt-1 text-xs text-red-600" />
                            </x-shop::form.control-group>

                            <!-- Captcha (If Configured) -->
                            @if (core()->getConfigData('customer.captcha.credentials.status'))
                                <x-shop::form.control-group class="mb-5">
                                    {!! \Webkul\Customer\Facades\Captcha::render() !!}

                                    <x-shop::form.control-group.error control-name="recaptcha_token" class="mt-1 text-xs text-red-600" />
                                </x-shop::form.control-group>
                            @endif

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button
                                    class="w-full h-12 rounded-full bg-[#f29a38] hover:bg-[#e08927] text-white text-xs uppercase tracking-[0.15em] font-bold flex items-center justify-center gap-2 shadow-lg shadow-[#f29a38]/30 hover:shadow-[#f29a38]/50 transition-all duration-300 transform hover:-translate-y-0.5"
                                    type="submit"
                                >
                                    <span>Send Message</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </x-shop::form>
                    </div>
                </div>
            </div>
        </main>

        <!-- SECTION 3: EMBEDDED GOOGLE MAP LOCATION -->
        <section class="py-12 bg-white border-t border-slate-200">
            <div class="site-container">
                <div class="max-w-3xl mx-auto text-center space-y-3 mb-8">
                    <span class="text-xs font-bold uppercase tracking-[0.22em] text-[#2ca7a3]">Visit Our Facility</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                        Registered Headquarters &amp; Fulfillment Center
                    </h2>
                    <p class="text-xs sm:text-sm text-[#6b7280]">
                        Located within the ALEAP Industrial Estate, Gajularamaram, Hyderabad.
                    </p>
                </div>

                <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-md bg-slate-100">
                    <iframe
                        class="w-full h-80 sm:h-96 border-0"
                        loading="lazy"
                        src="https://maps.google.com/maps?q=Involute%20Institute%20of%20Industrial%20Training%2C%20Shed%20No%201%2CSurvy%20No342%2C%20ALEAP%20Industrial%20Estate%2C%20Gajularamaram%2C%20Road%20Number%2010%2C%20Pragathi%20Nagar%2C%20Hyderabad%2C%20Medchal%20Malkajgiri%2C%20Telangana%20-%20500090.&t=m&z=16&output=embed&iwloc=near"
                        title="Involute Institute of Industrial Training, Shed No 1,Survy No342, ALEAP Industrial Estate, Gajularamaram, Road Number 10, Pragathi Nagar, Hyderabad, Medchal Malkajgiri, Telangana - 500090."
                        aria-label="Involute Institute of Industrial Training, Shed No 1,Survy No342, ALEAP Industrial Estate, Gajularamaram, Road Number 10, Pragathi Nagar, Hyderabad, Medchal Malkajgiri, Telangana - 500090."
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </section>

        <!-- SECTION 4: FREQUENT INQUIRY ACCORDION -->
        <section class="py-16 sm:py-24 bg-[#f5f7fa] border-t border-slate-200">
            <div class="site-container">
                <div class="max-w-3xl mx-auto text-center space-y-3 mb-12">
                    <span class="text-xs font-bold uppercase tracking-[0.22em] text-[#2ca7a3]">Quick Answers</span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-[#133b63]">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                        Instant clarity on our bamboo yarn technology, diabetic footcare designs, shipping, and sizing.
                    </p>
                </div>

                <div class="max-w-4xl mx-auto space-y-4">
                    {{-- FAQ 1 --}}
                    <details class="group rounded-2xl border border-slate-200 bg-white p-6 transition-all duration-300 open:border-[#2ca7a3]/40 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between text-base sm:text-lg font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="flex items-center gap-3.5 pr-4">
                                <i class="fa-solid fa-truck text-[#2ca7a3] text-lg shrink-0"></i>
                                <span>How quickly will my order be dispatched and delivered?</span>
                            </span>
                            <i class="fa-solid fa-plus text-[#2ca7a3] shrink-0 transition-transform duration-300 group-open:rotate-45 text-base"></i>
                        </summary>
                        <div class="pt-4 text-xs sm:text-sm text-[#6b7280] leading-relaxed border-t border-slate-100 mt-4 pl-9">
                            All orders placed before 2:00 PM IST on business days are dispatched within 24 hours directly from our fulfillment center. Delivery across major metro cities takes 2–4 business days, and 3–5 business days for regional pin codes. Real-time SMS and email tracking links are shared upon dispatch. Free shipping is provided on all orders above ₹499.
                        </div>
                    </details>

                    {{-- FAQ 2 --}}
                    <details class="group rounded-2xl border border-slate-200 bg-white p-6 transition-all duration-300 open:border-[#2ca7a3]/40 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between text-base sm:text-lg font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="flex items-center gap-3.5 pr-4">
                                <i class="fa-solid fa-heart-pulse text-[#f29a38] text-lg shrink-0"></i>
                                <span>What makes SOX N SOX socks suitable for diabetic feet?</span>
                            </span>
                            <i class="fa-solid fa-plus text-[#f29a38] shrink-0 transition-transform duration-300 group-open:rotate-45 text-base"></i>
                        </summary>
                        <div class="pt-4 text-xs sm:text-sm text-[#6b7280] leading-relaxed border-t border-slate-100 mt-4 pl-9">
                            Our medical-grade diabetic socks are designed with non-elastic top bands that do not pinch or leave constricting ring marks, promoting unrestricted blood circulation. The flat hand-linked seamless toe prevents friction blisters, and the natural bamboo fibers provide antimicrobial protection.
                        </div>
                    </details>

                    {{-- FAQ 3 --}}
                    <details class="group rounded-2xl border border-slate-200 bg-white p-6 transition-all duration-300 open:border-[#2ca7a3]/40 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between text-base sm:text-lg font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="flex items-center gap-3.5 pr-4">
                                <i class="fa-solid fa-ruler-combined text-[#1d5b8f] text-lg shrink-0"></i>
                                <span>How do I know which sock size to purchase?</span>
                            </span>
                            <i class="fa-solid fa-plus text-[#1d5b8f] shrink-0 transition-transform duration-300 group-open:rotate-45 text-base"></i>
                        </summary>
                        <div class="pt-4 text-xs sm:text-sm text-[#6b7280] leading-relaxed border-t border-slate-100 mt-4 pl-9">
                            Our socks are crafted using 4-way elastic stretch woven with elastane that fits shoe sizes UK/India 6 through 11 comfortably for men and women. Kids socks are specially graded for growing feet ages 4–12.
                        </div>
                    </details>

                    {{-- FAQ 4 --}}
                    <details class="group rounded-2xl border border-slate-200 bg-white p-6 transition-all duration-300 open:border-[#2ca7a3]/40 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between text-base sm:text-lg font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="flex items-center gap-3.5 pr-4">
                                <i class="fa-solid fa-soap text-[#2ca7a3] text-lg shrink-0"></i>
                                <span>How should I wash and care for bamboo socks?</span>
                            </span>
                            <i class="fa-solid fa-plus text-[#2ca7a3] shrink-0 transition-transform duration-300 group-open:rotate-45 text-base"></i>
                        </summary>
                        <div class="pt-4 text-xs sm:text-sm text-[#6b7280] leading-relaxed border-t border-slate-100 mt-4 pl-9">
                            To ensure optimal longevity and silkiness, machine wash cold on a gentle cycle or hand wash with mild detergent. Avoid bleach and fabric softeners (which coat bamboo micro-pores). Line dry in the shade or tumble dry on low heat.
                        </div>
                    </details>

                    {{-- FAQ 5 --}}
                    <details class="group rounded-2xl border border-slate-200 bg-white p-6 transition-all duration-300 open:border-[#2ca7a3]/40 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between text-base sm:text-lg font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="flex items-center gap-3.5 pr-4">
                                <i class="fa-solid fa-handshake text-[#f29a38] text-lg shrink-0"></i>
                                <span>Do you offer corporate gifting or wholesale pricing?</span>
                            </span>
                            <i class="fa-solid fa-plus text-[#f29a38] shrink-0 transition-transform duration-300 group-open:rotate-45 text-base"></i>
                        </summary>
                        <div class="pt-4 text-xs sm:text-sm text-[#6b7280] leading-relaxed border-t border-slate-100 mt-4 pl-9">
                            Yes! We supply custom branded gift boxes, multi-pack bundles, and bulk wholesale cartons to clinics, hospitals, corporate programs, and retailers across India. Please contact <a href="mailto:sales@soxnsox.in" class="text-[#1d5b8f] font-bold underline">sales@soxnsox.in</a> or call / WhatsApp us directly at +91 81061 55111.
                        </div>
                    </details>
                </div>
            </div>
        </section>

        <!-- SECTION 5: TRUST PILLARS STRIP -->
        <section class="py-12 bg-white border-t border-slate-200">
            <div class="site-container">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-[#f5f7fa] border border-slate-200 shadow-xs">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#e6f8f7] text-[#2ca7a3] shrink-0">
                            <i class="fa-solid fa-leaf text-base"></i>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-[#133b63]">100% Pure Bamboo</p>
                            <p class="text-[11px] text-[#6b7280]">2x softer than cotton</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-4 rounded-xl bg-[#f5f7fa] border border-slate-200 shadow-xs">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#fff4e8] text-[#f29a38] shrink-0">
                            <i class="fa-solid fa-heart-pulse text-base"></i>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-[#133b63]">Diabetic Fit</p>
                            <p class="text-[11px] text-[#6b7280]">Non-binding top cuffs</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-4 rounded-xl bg-[#f5f7fa] border border-slate-200 shadow-xs">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#e9f2fa] text-[#1d5b8f] shrink-0">
                            <i class="fa-solid fa-circle-check text-base"></i>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-[#133b63]">Seamless Toe</p>
                            <p class="text-[11px] text-[#6b7280]">Zero friction blister shield</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-4 rounded-xl bg-[#f5f7fa] border border-slate-200 shadow-xs">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#e6f8f7] text-[#2ca7a3] shrink-0">
                            <i class="fa-solid fa-wind text-base"></i>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-[#133b63]">Odor Free</p>
                            <p class="text-[11px] text-[#6b7280]">Natural antibacterial fiber</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        @if (core()->getConfigData('customer.captcha.credentials.status'))
            {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}
        @endif
    @endpush
</x-shop::layouts>
