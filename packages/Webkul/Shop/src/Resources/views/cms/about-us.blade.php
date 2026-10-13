<div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
    @if (core()->getConfigData('general.general.breadcrumbs.shop'))
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <span class="text-[#133b63] font-semibold">About Us</span>
            </nav>
        </div>
    @endif

    <!-- SECTION 1: HERO & CORE IDENTITY -->
    <section class="site-container pt-6 pb-12 sm:pt-10 sm:pb-16 border-b border-slate-200 reveal-on-scroll">
        <div class="max-w-3xl mx-auto text-center space-y-5 mb-8">
            <!-- Brand Tagline Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold tracking-widest uppercase border border-[#2ca7a3]/25 shadow-xs">
                <i class="fa-solid fa-award text-[#2ca7a3] text-sm"></i>
                <span>Our Brand &bull; Classic Knitters Pvt. Ltd. &bull; Est. 2022</span>
            </div>

            <!-- Main Heading -->
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#133b63] leading-[1.14]">
                About Us <br class="hidden sm:inline">
                <span class="text-[#f29a38] text-2xl sm:text-4xl lg:text-5xl font-bold block mt-2">Designed for comfort, built for everyday performance</span>
            </h1>

            <div class="soxnsox-decorative-line-center my-4"></div>

            <!-- Mission Lead Paragraph -->
            <p class="text-base sm:text-lg lg:text-xl leading-relaxed text-[#6b7280]">
                From everyday movement to everyday comfort. SOX N SOX was created with a simple idea &mdash; everyday foot comfort should never be overlooked.
            </p>
        </div>

        <!-- Hero Featured Lifestyle Visual (Full site-container width) -->
        <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-slate-900 group">
                <img
                    src="{{ asset('images/about/everyday-movement.png') }}"
                    alt="SOX N SOX Everyday Movement & Everyday Comfort"
                    class="w-full h-72 sm:h-96 lg:h-[460px] object-cover object-center transition-transform duration-700 group-hover:scale-105 opacity-90"
                    loading="eager"
                />
                
                <!-- Floating Quality Badges -->
                <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-10 text-left" style="background: linear-gradient(to top, rgba(19, 59, 99, 0.95) 0%, rgba(19, 59, 99, 0.6) 50%, rgba(19, 59, 99, 0) 100%);">
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #2ca7a3;">
                            <i class="fa-solid fa-leaf text-xs"></i> 100% Pure Bamboo Yarn
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #f29a38;">
                            <i class="fa-solid fa-heart-pulse text-xs"></i> Zero-Pressure Cuff
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-md" style="background-color: #1d5b8f;">
                            <i class="fa-solid fa-certificate text-xs"></i> 200-Needle Knit
                        </span>
                    </div>
                    <p class="text-white text-sm sm:text-base font-semibold max-w-xl drop-shadow-sm">
                        Engineered with silk-soft bamboo fiber, hand-linked seamless toes, and medical-grade diabetic comfort.
                    </p>
                </div>
            </div>

            <!-- 4 Trust Metrics Row -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 pt-6 text-left reveal-stagger">
                <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300">
                    <p class="font-display text-3xl font-extrabold text-[#133b63]">2X</p>
                    <p class="text-xs uppercase tracking-wider text-[#2ca7a3] font-bold mt-1">Softer Than Cotton</p>
                    <p class="text-[11px] text-[#6b7280] mt-0.5">Naturally round, silky bamboo fibers prevent skin friction.</p>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300">
                    <p class="font-display text-3xl font-extrabold text-[#133b63]">0%</p>
                    <p class="text-xs uppercase tracking-wider text-[#f29a38] font-bold mt-1">Constriction</p>
                    <p class="text-[11px] text-[#6b7280] mt-0.5">Doctor-recommended non-binding honeycomb cuffs promote circulation.</p>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#1d5b8f]/40 transition-all duration-300">
                    <p class="font-display text-3xl font-extrabold text-[#133b63]">100%</p>
                    <p class="text-xs uppercase tracking-wider text-[#1d5b8f] font-bold mt-1">Seamless Toe</p>
                    <p class="text-[11px] text-[#6b7280] mt-0.5">Hand-linked 0mm flat toe eliminates rubbing &amp; blister risk.</p>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300">
                    <p class="font-display text-3xl font-extrabold text-[#133b63]">99.8%</p>
                    <p class="text-xs uppercase tracking-wider text-[#2ca7a3] font-bold mt-1">Odor Defense</p>
                    <p class="text-[11px] text-[#6b7280] mt-0.5">Bamboo Kun bio-agents eliminate odor-causing bacteria all day.</p>
                </div>
            </div>
    </section>

    <!-- SECTION 2: THE FOUNDING STORY & CORPORATE IDENTITY -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Left Story Column -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                        <span class="h-2 w-2 rounded-full bg-[#2ca7a3]"></span>
                        <span>Our Brand</span>
                    </div>

                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                        Everyday Comfort Should Never Be Overlooked
                    </h2>

                    <div class="soxnsox-decorative-line my-4"></div>

                    <p class="text-sm sm:text-base leading-relaxed text-[#6b7280]">
                        Powered by <strong class="text-[#133b63]">Classic Knitters Pvt. Ltd.</strong>, incorporated on <strong class="text-[#133b63]">19/05/2022</strong>, our brand was built to redefine how people experience socks in their daily lives.
                    </p>

                    <p class="text-sm sm:text-base leading-relaxed text-[#6b7280]">
                        From long work hours and travel to active routines and everyday movement, we noticed that most socks focused only on appearance while ignoring real comfort, support, and durability. That’s why SOX N SOX was created &mdash; to design socks that combine comfort, performance, breathability, and modern style for people of all ages.
                    </p>

                    <p class="text-sm sm:text-base leading-relaxed text-[#6b7280]">
                        Today, we continue to build a growing lifestyle sock brand offering collections for Men, Women, Children, Medical Support, and Everyday Essentials.
                    </p>

                    <div class="pt-2">
                        <blockquote class="p-6 rounded-2xl bg-[#f5f7fa] border-l-4 border-[#2ca7a3] text-sm sm:text-base italic text-[#133b63] font-medium leading-relaxed">
                            &ldquo;Our mission is simple: to make every step softer, lighter, and more comfortable.&rdquo;
                        </blockquote>
                    </div>

                    <!-- Company Identity Pill -->
                    <div class="inline-flex flex-wrap items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-[#133b63] border border-slate-200">
                        <i class="fa-solid fa-building text-[#2ca7a3]"></i>
                        <span>Classic Knitters Private Limited &bull; CIN / Inc. Date: 19/05/2022</span>
                    </div>
                </div>

                <!-- Right Lifestyle Visual Column -->
                <div class="lg:col-span-5 relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-white group">
                        <img
                            src="{{ asset('images/about/outdoor-lifestyle.png') }}"
                            alt="SOX N SOX Outdoor Everyday Lifestyle"
                            class="w-full h-auto object-cover object-center max-h-[520px] group-hover:scale-105 transition-transform duration-700 ease-out"
                            loading="lazy"
                        />
                    </div>

                    <!-- Floating Feature Card: positioned under the image with slight overlap over the bottom edge -->
                    <div style="margin-top: -52px;" class="relative mx-4 sm:mx-6 z-10 bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-4.5 shadow-xl border border-slate-200/90 transition-all duration-300 ease-out hover:shadow-2xl hover:-translate-y-1.5 hover:border-[#2ca7a3]/50 hover:ring-2 hover:ring-[#2ca7a3]/20 group/card cursor-default">
                        <div class="flex items-center gap-3.5">
                            <div class="h-11 w-11 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center text-lg flex-shrink-0 transition-all duration-300 ease-out group-hover/card:scale-110 group-hover/card:rotate-6 group-hover/card:bg-[#2ca7a3] group-hover/card:text-white shadow-xs">
                                <i class="fa-solid fa-person-walking"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-[#133b63] uppercase tracking-wide transition-colors duration-300 group-hover/card:text-[#2ca7a3]">Everyday Lifestyle &amp; Movement</p>
                                <p class="text-[11px] sm:text-xs text-[#6b7280] mt-0.5 leading-snug">Designed to support you seamlessly through work, commute, and leisure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: QUALITY & CRAFTSMANSHIP (Reverse Grid with Bamboo Knit Detail Photo) -->
    <section class="py-16 sm:py-24 bg-[#f5f7fa] border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Left Knit Detail Image -->
                <div class="lg:col-span-5 order-2 lg:order-1 relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200 bg-white group">
                        <img
                            src="{{ asset('images/about/bamboo-craftsmanship.png') }}"
                            alt="SOX N SOX Bamboo Knit Precision Craftsmanship"
                            class="w-full h-auto object-cover object-center max-h-[480px] group-hover:scale-105 transition-transform duration-700 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 left-4 bg-[#133b63]/90 backdrop-blur-md text-white rounded-xl px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider shadow-md">
                            <i class="fa-solid fa-microchip text-[#2ca7a3] mr-1.5"></i> 200-Needle High Density Knit
                        </div>
                    </div>
                </div>

                <!-- Right Pillars Description Column -->
                <div class="lg:col-span-7 order-1 lg:order-2 space-y-6">
                    <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#f29a38]">
                        <span class="h-2 w-2 rounded-full bg-[#f29a38]"></span>
                        <span>Quality &amp; Performance</span>
                    </div>

                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                        We Design Socks That Balance Comfort, Support &amp; Everyday Performance
                    </h2>

                    <div class="soxnsox-decorative-line my-4"></div>

                    <p class="text-sm sm:text-base leading-relaxed text-[#6b7280]">
                        At <strong class="text-[#133b63]">SOX N SOX</strong>, every product is thoughtfully designed using breathable materials, soft-touch fabrics, and durable construction techniques to ensure lasting comfort throughout the day.
                    </p>

                    <p class="text-sm sm:text-base leading-relaxed text-[#6b7280]">
                        Whether it’s daily wear, travel, active movement, work routines, or relaxation, our socks are built to provide a better wearing experience in every step.
                    </p>

                    <!-- 5 Core Pillars Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 reveal-stagger">
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-feather"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Comfort</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Silky bamboo touch that feels gentle on sensitive and diabetic skin.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#fff4e8] text-[#f29a38] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-shield"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Durability</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">High-tensile bamboo fibers reinforced at high-wear stress zones.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#1d5b8f]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#e9f2fa] text-[#1d5b8f] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-arrows-up-down-left-right"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Flexibility</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Adaptive 4-way stretch with elastane that moves naturally with your stride.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-wind"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Breathability</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Micro-ventilated knit promoting continuous airflow and moisture control.</p>
                            </div>
                        </div>

                        <div class="sm:col-span-2 p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300 flex items-start gap-3.5">
                            <span class="h-9 w-9 rounded-xl bg-[#fff4e8] text-[#f29a38] flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-[#133b63]">Modern Design</h3>
                                <p class="text-xs text-[#6b7280] mt-0.5">Refined, contemporary aesthetic tailored for work, athletic workouts, and home relaxation.</p>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs font-bold uppercase tracking-wider text-[#2ca7a3] pt-1">
                        &bull; Because great comfort starts from the ground up.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: BUILT FOR REAL PEOPLE & REAL EVERYDAY NEEDS (3-Card Image Grid) -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-14">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#e6f8f7] text-[#2ca7a3] border border-[#2ca7a3]/25">
                    Customer First Approach
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Built For Real People &amp; Real Everyday Needs
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-2xl mx-auto">
                    We believe socks are more than just an accessory &mdash; they are part of your everyday lifestyle. That’s why SOX N SOX creates products designed for real daily routines, helping people stay comfortable whether working, traveling, exercising, or relaxing.
                </p>
            </div>

            <!-- 3 Lifestyle Photography Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 reveal-stagger">
                <!-- Card 1: Work & Travel -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-64 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/about/travel-commute.png') }}"
                            alt="SOX N SOX Travel and Work Commute Socks"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider text-[#133b63] shadow-xs">
                            Work &amp; Commute
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="text-lg font-bold text-[#133b63]">Long Hours &amp; Travel</h3>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed mt-1.5">
                                Engineered for long hours on your feet, flights, and daily commutes without heavy legs or painful calf elastic marks.
                            </p>
                        </div>
                        <div class="pt-2 text-xs font-semibold text-[#2ca7a3] flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i> Non-binding gentle cuffs
                        </div>
                    </div>
                </div>

                <!-- Card 2: Fitness & Active Routines -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-64 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/about/active-runner.png') }}"
                            alt="SOX N SOX Active Fitness & Sports Socks"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider text-[#f29a38] shadow-xs">
                            Active Routines
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="text-lg font-bold text-[#133b63]">Movement &amp; Performance</h3>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed mt-1.5">
                                High-traction grips, arch compression, and rapid moisture dispersal designed for gym, jogging, and active days.
                            </p>
                        </div>
                        <div class="pt-2 text-xs font-semibold text-[#f29a38] flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i> Anti-blister ventilation
                        </div>
                    </div>
                </div>

                <!-- Card 3: Home & Relaxation -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-64 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/about/everyday-comfort-relax.png') }}"
                            alt="SOX N SOX Relaxation and Lounging Socks"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider text-[#2ca7a3] shadow-xs">
                            Home &amp; Lounging
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="text-lg font-bold text-[#133b63]">Cloud-Like Comfort</h3>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed mt-1.5">
                                Ultra-plush, thermo-regulating bamboo weave designed for relaxing, quiet evenings, and refreshing restful sleep.
                            </p>
                        </div>
                        <div class="pt-2 text-xs font-semibold text-[#2ca7a3] flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i> 100% Hypoallergenic softness
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: TECHNICAL INNOVATIONS & ANATOMY BADGES -->
    <section class="py-16 sm:py-24 bg-[#f5f7fa] border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-14">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#e9f2fa] text-[#1d5b8f] border border-[#1d5b8f]/25">
                    The Science of Foot Health
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Engineered With Medical-Grade Precision
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                    Every pair incorporates biomechanical knitting designed to optimize blood flow, cushion impacts, and protect sensitive feet.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 reveal-stagger">
                <!-- Innovation 1 -->
                <div class="p-8 rounded-3xl bg-white border border-slate-200/90 shadow-sm text-center flex flex-col items-center space-y-4 hover:shadow-xl hover:-translate-y-1.5 hover:border-[#2ca7a3]/50 transition-all duration-300">
                    <div class="h-28 w-28 rounded-2xl overflow-hidden bg-slate-50 p-2 flex items-center justify-center">
                        <img
                            src="{{ asset('images/about/tech-breathability.png') }}"
                            alt="Micro-Ventilated Bamboo Knit"
                            class="max-h-full max-w-full object-contain"
                            loading="lazy"
                        />
                    </div>
                    <h3 class="text-lg font-bold text-[#133b63]">Micro-Ventilated Weave</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Hollow-core bamboo fibers wick moisture away 3x faster than traditional fabrics, keeping feet dry, odor-free, and blister-protected.
                    </p>
                </div>

                <!-- Innovation 2 -->
                <div class="p-8 rounded-3xl bg-white border border-slate-200/90 shadow-sm text-center flex flex-col items-center space-y-4 hover:shadow-xl hover:-translate-y-1.5 hover:border-[#f29a38]/50 transition-all duration-300">
                    <div class="h-28 w-28 rounded-2xl overflow-hidden bg-slate-50 p-2 flex items-center justify-center">
                        <img
                            src="{{ asset('images/about/tech-arch-support.png') }}"
                            alt="Ergonomic Arch Compression Band"
                            class="max-h-full max-w-full object-contain"
                            loading="lazy"
                        />
                    </div>
                    <h3 class="text-lg font-bold text-[#133b63]">Targeted Arch Support</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        360-degree mid-foot elastic ribbing hugs the plantar fascia, preventing sock slippage and relieving arch strain throughout long active days.
                    </p>
                </div>

                <!-- Innovation 3 -->
                <div class="p-8 rounded-3xl bg-white border border-slate-200/90 shadow-sm text-center flex flex-col items-center space-y-4 hover:shadow-xl hover:-translate-y-1.5 hover:border-[#1d5b8f]/50 transition-all duration-300">
                    <div class="h-28 w-28 rounded-2xl overflow-hidden bg-slate-50 p-2 flex items-center justify-center">
                        <img
                            src="{{ asset('images/about/tech-cushion.png') }}"
                            alt="Terry Cushioning & Heel Protection"
                            class="max-h-full max-w-full object-contain"
                            loading="lazy"
                        />
                    </div>
                    <h3 class="text-lg font-bold text-[#133b63]">Shock-Absorbing Terry Sole</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        High-density terry loops line the heel and sole to cushion repeated footsteps against hard floors, protecting joints and heel nerves.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 6: MISSION & CALL TO ACTION -->
    <section class="py-16 sm:py-24 bg-white reveal-on-scroll">
        <div class="site-container text-center">
            <div class="max-w-3xl mx-auto space-y-6">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#fff4e8] text-[#f29a38] border border-[#f29a38]/25">
                Our Mission &amp; Responsibility
            </span>

            <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                Comfort, Quality &amp; Everyday Confidence In Every Pair
            </h2>

            <div class="soxnsox-decorative-line-center my-4"></div>

            <p class="text-base sm:text-lg leading-relaxed text-[#6b7280] max-w-2xl mx-auto">
                We believe premium comfort should be accessible to everyone. Our mission is to create socks that support daily movement while delivering softness, durability, breathability, and long-lasting comfort for Men, Women, and Children.
            </p>

            <div class="pt-6 flex flex-wrap justify-center gap-4">
                <a
                    href="{{ route('shop.products.index') }}"
                    class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 inline-flex items-center gap-2 px-8 py-4 text-xs font-bold uppercase tracking-widest rounded-full shadow-lg hover:shadow-xl transition-all duration-300"
                >
                    <span>Shop All Collections</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>

                <a
                    href="{{ route('shop.cms.page', 'why-choose-us') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 text-xs font-bold uppercase tracking-widest rounded-full border border-slate-300 bg-white text-[#133b63] hover:bg-slate-50 hover:border-[#2ca7a3]/50 transition-all duration-300 active:scale-95 shadow-xs hover:shadow-md"
                >
                    <span>Why Choose Us</span>
                    <i class="fa-solid fa-chevron-right text-xs text-[#2ca7a3]"></i>
                </a>
            </div>
        </div>
    </div>
</section>
</div>
