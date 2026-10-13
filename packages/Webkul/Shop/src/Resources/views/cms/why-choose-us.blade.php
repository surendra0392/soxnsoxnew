<div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
    @if (core()->getConfigData('general.general.breadcrumbs.shop'))
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <span class="text-[#133b63] font-semibold">Why Choose Us</span>
            </nav>
        </div>
    @endif

    <!-- SECTION 1: HERO -->
    <section class="site-container pt-6 pb-12 sm:pt-10 sm:pb-16 border-b border-slate-200 reveal-on-scroll">
        <div class="max-w-3xl mx-auto text-center space-y-5 mb-8">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold tracking-widest uppercase border border-[#2ca7a3]/25 shadow-xs">
                <i class="fa-solid fa-shield-halved text-[#2ca7a3] text-sm"></i>
                <span>The Comfort System &bull; Simple Comfort &bull; Everyday Life</span>
            </div>

            <!-- Main Heading -->
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#133b63] leading-[1.14]">
                Why Choose Us <br class="hidden sm:inline">
                <span class="text-[#f29a38] text-2xl sm:text-4xl lg:text-5xl font-bold block mt-2">Designed For Comfort. Built For Everyday Life.</span>
            </h1>

            <div class="soxnsox-decorative-line-center my-4"></div>

            <p class="text-base sm:text-lg lg:text-xl leading-relaxed text-[#6b7280]">
                Every pair of SOX N SOX is precision-engineered to support your daily movement, relieve foot stress, and keep you feeling light and energized from morning to night.
            </p>
        </div>

        <!-- Hero Featured Visual Banner (Full site-container width) -->
        <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-slate-900 group">
                <img
                    src="{{ asset('images/about/office-work-desk.png') }}"
                    alt="SOX N SOX Everyday Office & Lifestyle Comfort"
                    class="w-full h-72 sm:h-96 lg:h-[460px] object-cover object-center transition-transform duration-700 group-hover:scale-105 opacity-95"
                    loading="eager"
                />
                
                <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-10 text-left" style="background: linear-gradient(to top, rgba(19, 59, 99, 0.95) 0%, rgba(19, 59, 99, 0.6) 50%, rgba(19, 59, 99, 0) 100%);">
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #2ca7a3;">
                            <i class="fa-solid fa-briefcase text-xs"></i> All-Day Desk &amp; Work Fit
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #f29a38;">
                            <i class="fa-solid fa-feather text-xs"></i> Non-Binding Elastic Cuffs
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #1d5b8f;">
                            <i class="fa-solid fa-certificate text-xs"></i> Zero Pressure Lines
                        </span>
                    </div>
                    <p class="text-white text-sm sm:text-base font-semibold max-w-xl drop-shadow-sm">
                        Experience dress and casual socks crafted with sustainable bamboo fiber that never leave marks or restrict healthy circulation.
                    </p>
                </div>
            </div>

            <!-- 3 Pillars of The Comfort System -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 text-left reveal-stagger">
                <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-[#2ca7a3]/40 transition-all duration-300 space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e6f8f7] text-[#2ca7a3]">
                            <i class="fa-solid fa-crosshairs text-base"></i>
                        </span>
                        <h3 class="font-display text-lg font-bold text-[#133b63]">Supportive Fit</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Comfort-focused construction designed to provide a secure and supportive feel throughout the day without tight pressure points.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-[#f29a38]/40 transition-all duration-300 space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff4e8] text-[#f29a38]">
                            <i class="fa-solid fa-arrows-up-down-left-right text-base"></i>
                        </span>
                        <h3 class="font-display text-lg font-bold text-[#133b63]">Flexible Movement</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Soft stretch materials move naturally with your feet for unrestricted everyday comfort and active mobility.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-[#1d5b8f]/40 transition-all duration-300 space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e9f2fa] text-[#1d5b8f]">
                            <i class="fa-solid fa-wind text-base"></i>
                        </span>
                        <h3 class="font-display text-lg font-bold text-[#133b63]">Breathable Comfort</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Lightweight breathable fabrics help maintain airflow, regulate temperature, and preserve freshness all day long.
                    </p>
                </div>
            </div>
    </section>

    <!-- SECTION 2: OUR PROMISE (3 Lifestyle Cards with Authentic Photography) -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-14">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#fff4e8] text-[#f29a38] border border-[#f29a38]/25">
                    Our Promise
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Comfort You Can Feel In Every Step
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                    We engineer every element of SOX N SOX socks around your daily physical routine, whether you're working, traveling, or relaxing.
                </p>
            </div>

            <!-- 3 Lifestyle Cards with Images -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 reveal-stagger">
                <!-- Promise Card 1 -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-60 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/about/travel-commute.png') }}"
                            alt="SOX N SOX Everyday Travel and Commute Support"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider text-[#133b63] shadow-xs">
                            Everyday Support
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="font-display text-lg font-bold text-[#133b63]">Long Days &amp; Travel</h3>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed mt-1.5">
                                Designed to keep feet feeling comfortable and light during busy work hours, long-distance flights, walking, and demanding daily schedules.
                            </p>
                        </div>
                        <div class="pt-2 text-xs font-semibold text-[#2ca7a3] flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i> Gentle 360&deg; mid-foot support
                        </div>
                    </div>
                </div>

                <!-- Promise Card 2 -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-60 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/about/active-runner.png') }}"
                            alt="SOX N SOX Breathable Active Workout Socks"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider text-[#f29a38] shadow-xs">
                            Breathable Design
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="font-display text-lg font-bold text-[#133b63]">Active Temperature Control</h3>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed mt-1.5">
                                Natural thermal balancing keeps feet cool in hot weather and warm in cooler conditions, wicking moisture rapidly to stop odors and blisters.
                            </p>
                        </div>
                        <div class="pt-2 text-xs font-semibold text-[#f29a38] flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i> Continuous micro-mesh ventilation
                        </div>
                    </div>
                </div>

                <!-- Promise Card 3 -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-60 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/about/home-relax-ottoman.png') }}"
                            alt="SOX N SOX Made To Last Quality Construction"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider text-[#2ca7a3] shadow-xs">
                            Made To Last
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="font-display text-lg font-bold text-[#133b63]">Durable Quality</h3>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed mt-1.5">
                                High-durability knitting techniques and reinforced stress areas ensure shape retention, soft hand-feel, and elasticity through 50+ wash cycles.
                            </p>
                        </div>
                        <div class="pt-2 text-xs font-semibold text-[#2ca7a3] flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i> High-density double-layer yarns
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: 6 PILLARS OF WHY SOX N SOX (Side-by-side with Craftsmanship Detail) -->
    <section class="py-16 sm:py-24 bg-[#f5f7fa] border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Left Detail Image Column -->
                <div class="lg:col-span-5 relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-white group">
                        <img
                            src="{{ asset('images/about/bamboo-craftsmanship.png') }}"
                            alt="SOX N SOX Precision Knitting"
                            class="w-full h-auto object-cover object-center max-h-[520px] group-hover:scale-105 transition-transform duration-700 ease-out"
                            loading="lazy"
                        />
                    </div>

                    <!-- Floating Feature Card: positioned under the image with slight overlap over the bottom edge -->
                    <div style="margin-top: -52px;" class="relative mx-4 sm:mx-6 z-10 bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-4.5 shadow-xl border border-slate-200/90 transition-all duration-300 ease-out hover:shadow-2xl hover:-translate-y-1.5 hover:border-[#2ca7a3]/50 hover:ring-2 hover:ring-[#2ca7a3]/20 group/card cursor-default">
                        <div class="flex items-center gap-3.5">
                            <div class="h-11 w-11 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center text-lg flex-shrink-0 transition-all duration-300 ease-out group-hover/card:scale-110 group-hover/card:rotate-6 group-hover/card:bg-[#2ca7a3] group-hover/card:text-white shadow-xs">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-[#133b63] uppercase tracking-wide transition-colors duration-300 group-hover/card:text-[#2ca7a3]">More Than Just Socks</p>
                                <p class="text-[11px] sm:text-xs text-[#6b7280] mt-0.5 leading-snug">Thoughtfully designed for real daily living from morning to night.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right 6 Pillars Grid Column -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                        <span class="h-2 w-2 rounded-full bg-[#2ca7a3]"></span>
                        <span>Why SOX N SOX</span>
                    </div>

                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                        More Than Socks &mdash; Designed For Everyday Living
                    </h2>

                    <div class="soxnsox-decorative-line my-4"></div>

                    <p class="text-sm sm:text-base leading-relaxed text-[#6b7280]">
                        We combine breathable materials, flexible ergonomics, and premium bamboo fibers to craft footwear that enhances everyday movement.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 reveal-stagger">
                        <!-- Pillar 1 -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-heart"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Comfort First</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Designed around genuine softness that cushions and cradles sensitive feet all day.</p>
                            </div>
                        </div>

                        <!-- Pillar 2 -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#fff4e8] text-[#f29a38] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-leaf"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Breathable Fabrics</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Premium bamboo yarns that allow feet to breathe freely and eliminate perspiration.</p>
                            </div>
                        </div>

                        <!-- Pillar 3 -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#1d5b8f]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#e9f2fa] text-[#1d5b8f] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-shield-halved"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Everyday Durability</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Crafted with high quality control standards to withstand rigorous daily wear.</p>
                            </div>
                        </div>

                        <!-- Pillar 4 -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-person-walking"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Modern Fit</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Stays comfortably in position with zero constriction or painful elastic rings.</p>
                            </div>
                        </div>

                        <!-- Pillar 5 -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#fff4e8] text-[#f29a38] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-bolt"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Lifestyle Focused</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Tailored versatility for workplace, physical exercise, travel, and home relaxation.</p>
                            </div>
                        </div>

                        <!-- Pillar 6 -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#1d5b8f]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#e9f2fa] text-[#1d5b8f] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-people-group"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">For Everyone</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Carefully sized collections designed for Men, Women, Kids, and Diabetic health needs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: COMPARISON TABLE (SOXNSOX VS ORDINARY SOCKS) -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 reveal-on-scroll">
        <div class="site-container space-y-10">
            <div class="text-center space-y-4 max-w-2xl mx-auto">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#e6f8f7] text-[#2ca7a3] border border-[#2ca7a3]/25">
                    Clear Comparison
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63]">
                    The Difference Is In The Details
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280]">
                    See how SOX N SOX bamboo engineering compares to typical cotton and synthetic socks.
                </p>
            </div>

            <div class="rounded-3xl border border-slate-200 overflow-hidden shadow-sm bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-[#133b63] text-white text-xs uppercase tracking-wider">
                            <tr>
                                <th class="p-5 font-bold">Feature / Standard</th>
                                <th class="p-5 font-bold text-[#2ca7a3] bg-[#0c243d]">SOX N SOX Bamboo</th>
                                <th class="p-5 font-bold text-slate-300">Ordinary Cotton Socks</th>
                                <th class="p-5 font-bold text-slate-300">Synthetic Polyester Socks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-[#133b63]">
                            <tr class="hover:bg-[#f0faf9]/60 transition-colors">
                                <td class="p-5 font-semibold">Fabric Softness</td>
                                <td class="p-5 font-bold text-[#2ca7a3] bg-[#f0faf9]"><i class="fa-solid fa-circle-check mr-2"></i> Silk-smooth bamboo yarn (2x softer)</td>
                                <td class="p-5 text-[#6b7280]">Rougher fiber; stiffens over time</td>
                                <td class="p-5 text-[#6b7280]">Scratchy and synthetic feel</td>
                            </tr>
                            <tr class="hover:bg-[#f0faf9]/60 transition-colors">
                                <td class="p-5 font-semibold">Cuff &amp; Blood Circulation</td>
                                <td class="p-5 font-bold text-[#2ca7a3] bg-[#f0faf9]"><i class="fa-solid fa-circle-check mr-2"></i> Zero-pressure honeycomb band</td>
                                <td class="p-5 text-[#6b7280]">Tight rubber elastic marks</td>
                                <td class="p-5 text-[#6b7280]">High constriction pressure</td>
                            </tr>
                            <tr class="hover:bg-[#f0faf9]/60 transition-colors">
                                <td class="p-5 font-semibold">Toe Seam Friction</td>
                                <td class="p-5 font-bold text-[#2ca7a3] bg-[#f0faf9]"><i class="fa-solid fa-circle-check mr-2"></i> 0mm Hand-linked flat seam</td>
                                <td class="p-5 text-[#6b7280]">Bulky ridge; blister-prone</td>
                                <td class="p-5 text-[#6b7280]">Rough machine stitching</td>
                            </tr>
                            <tr class="hover:bg-[#f0faf9]/60 transition-colors">
                                <td class="p-5 font-semibold">Odor &amp; Moisture Control</td>
                                <td class="p-5 font-bold text-[#2ca7a3] bg-[#f0faf9]"><i class="fa-solid fa-circle-check mr-2"></i> Natural Bamboo Kun antimicrobial</td>
                                <td class="p-5 text-[#6b7280]">Traps moisture; encourages odor</td>
                                <td class="p-5 text-[#6b7280]">Non-absorbent; sweaty buildup</td>
                            </tr>
                            <tr class="hover:bg-[#f0faf9]/60 transition-colors">
                                <td class="p-5 font-semibold">Hypoallergenic &amp; Diabetic Safe</td>
                                <td class="p-5 font-bold text-[#2ca7a3] bg-[#f0faf9]"><i class="fa-solid fa-circle-check mr-2"></i> Yes, doctor-approved comfort</td>
                                <td class="p-5 text-[#6b7280]">Can irritate sensitive skin</td>
                                <td class="p-5 text-[#6b7280]">Risk of allergy &amp; heat rashes</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: CTA BANNER -->
    <section class="py-16 sm:py-24 bg-[#f5f7fa] reveal-on-scroll">
        <div class="site-container text-center">
            <div class="max-w-3xl mx-auto space-y-6">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#fff4e8] text-[#f29a38] border border-[#f29a38]/25">
                    Explore The Collection
                </span>

                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Experience Everyday Comfort With SOX N SOX
                </h2>

                <div class="soxnsox-decorative-line-center my-4"></div>

                <p class="text-base sm:text-lg leading-relaxed text-[#6b7280] max-w-2xl mx-auto">
                    Discover premium socks designed for modern lifestyles with comfort, support, durability, and style in every step.
                </p>

                <div class="pt-6 flex flex-wrap justify-center gap-4">
                    <a
                        href="{{ route('shop.products.index') }}"
                        class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 inline-flex items-center gap-2 px-8 py-4 text-xs font-bold uppercase tracking-widest rounded-full shadow-lg hover:shadow-xl transition-all duration-300"
                    >
                        <span>Shop Collection</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>

                    <a
                        href="{{ route('shop.cms.page', 'how-it-works') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 text-xs font-bold uppercase tracking-widest rounded-full border border-slate-300 bg-white text-[#133b63] hover:bg-slate-50 hover:border-[#2ca7a3]/50 transition-all duration-300 active:scale-95 shadow-xs hover:shadow-md"
                    >
                        <span>See How It Works</span>
                        <i class="fa-solid fa-chevron-right text-xs text-[#2ca7a3]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
