<div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
    @if (core()->getConfigData('general.general.breadcrumbs.shop'))
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <span class="text-[#133b63] font-semibold">How It Works</span>
            </nav>
        </div>
    @endif

    <!-- SECTION 1: HERO -->
    <section class="site-container pt-6 pb-12 sm:pt-10 sm:pb-16 border-b border-slate-200 reveal-on-scroll">
        <div class="max-w-3xl mx-auto text-center space-y-5 mb-8">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold tracking-widest uppercase border border-[#2ca7a3]/25 shadow-xs">
                <i class="fa-solid fa-gears text-[#2ca7a3] text-sm"></i>
                <span>The Comfort System &bull; Step-By-Step Engineering</span>
            </div>

            <!-- Main Heading -->
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#133b63] leading-[1.14]">
                How It Works <br class="hidden sm:inline">
                <span class="text-[#f29a38] text-2xl sm:text-4xl lg:text-5xl font-bold block mt-2">Designed To Deliver Comfort, Support &amp; Better Everyday Movement</span>
            </h1>

            <div class="soxnsox-decorative-line-center my-4"></div>

            <p class="text-base sm:text-lg lg:text-xl leading-relaxed text-[#6b7280]">
                Discover the thoughtful engineering, material science, and precision knitting behind every pair of SOX N SOX socks.
            </p>
        </div>

        <!-- Hero Featured Visual Showcase Card (Full site-container width) -->
        <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-white group">
                <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">
                    <!-- Sock Visual Column -->
                    <div class="lg:col-span-7 bg-white flex items-center justify-center relative border-b lg:border-b-0 lg:border-r border-slate-200 min-h-[360px] lg:min-h-[440px] overflow-hidden" style="background-color: #ffffff;">
                        <img
                            src="{{ asset('images/about/active-performance.png') }}"
                            alt="SOX N SOX Dynamic Everyday Movement & Engineering"
                            class="w-full h-full object-contain transition-transform duration-700 ease-out group-hover:scale-105"
                            loading="eager"
                        />
                        <div class="absolute top-4 left-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md border border-slate-200 text-[#133b63] shadow-xs z-10">
                            <i class="fa-solid fa-microchip text-[#2ca7a3]"></i> Medical-Grade 200-Needle Knit
                        </div>
                    </div>

                    <!-- Details Column with Solid High Contrast Background -->
                    <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 text-left space-y-4 flex flex-col justify-center" style="background-color: #133b63;">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase border border-white/20 w-fit text-[#2ca7a3] bg-white/10">
                            <i class="fa-solid fa-certificate"></i> Precision Engineering
                        </div>

                        <h3 class="font-display text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight">
                            Engineered For Better Everyday Movement
                        </h3>

                        <p class="text-slate-200 text-xs sm:text-sm leading-relaxed">
                            Crafted with sustainable bamboo fiber that breathes naturally, cushions plantar stress, and supports healthy all-day circulation without tight pinch points.
                        </p>

                        <div class="flex flex-wrap gap-2 pt-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-xs" style="background-color: #2ca7a3;">
                                <i class="fa-solid fa-microchip text-xs"></i> 200-Needle Weave
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-xs" style="background-color: #f29a38;">
                                <i class="fa-solid fa-shield-halved text-xs"></i> Non-Binding Cuff
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold tracking-wider uppercase text-white shadow-xs" style="background-color: #1d5b8f;">
                                <i class="fa-solid fa-feather text-xs"></i> 0mm Seamless Toe
                            </span>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- SECTION 2: THE COMFORT SYSTEM (3 Core Pillars with Authentic Photography) -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-14">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#e6f8f7] text-[#2ca7a3] border border-[#2ca7a3]/25">
                    The Comfort System
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Simple Comfort. Designed For Everyday Life.
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                    Three core principles combine to deliver footwear that effortlessly moves with your day:
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 reveal-stagger">
                <!-- Pillar 1: Supportive Fit -->
                <div class="rounded-3xl bg-white border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-64 sm:h-72 w-full overflow-hidden flex items-center justify-center border-b border-slate-100" style="height: 280px; background-color: #f8f7f6;">
                        <img
                            src="{{ asset('images/library/c11e2126-fb1e-4306-a64c-8428d04061d7.png') }}"
                            alt="SOX N SOX Supportive Fit Engineering"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3 py-1 rounded-full text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-[#2ca7a3] border border-teal-200/60 shadow-xs">
                            Ergonomic Architecture
                        </div>
                    </div>
                    <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#2ca7a3]"></span>
                                <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63]">Supportive Fit</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                                Comfort-focused construction designed to provide a secure and supportive feel throughout the day without tight pressure points.
                            </p>
                        </div>
                        <div class="pt-3 text-xs font-semibold text-[#2ca7a3] flex items-center gap-1.5 border-t border-slate-100">
                            <i class="fa-solid fa-circle-check text-xs"></i> 360&deg; mid-foot elastic ribbing
                        </div>
                    </div>
                </div>

                <!-- Pillar 2: Flexible Movement -->
                <div class="rounded-3xl bg-white border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-64 sm:h-72 w-full overflow-hidden flex items-center justify-center border-b border-slate-100" style="height: 280px; background-color: #f5f5f4;">
                        <img
                            src="{{ asset('images/library/337978d4-62b1-40ed-9df7-436519dac988.png') }}"
                            alt="SOX N SOX Flexible Movement Stretch"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3 py-1 rounded-full text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-[#f29a38] border border-amber-200/60 shadow-xs">
                            Dynamic Elasticity
                        </div>
                    </div>
                    <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#f29a38]"></span>
                                <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63]">Flexible Movement</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                                Soft stretch materials move naturally with your feet for unrestricted everyday comfort, walking ease, and active mobility.
                            </p>
                        </div>
                        <div class="pt-3 text-xs font-semibold text-[#f29a38] flex items-center gap-1.5 border-t border-slate-100">
                            <i class="fa-solid fa-circle-check text-xs"></i> 4-way elastic stretch woven fiber
                        </div>
                    </div>
                </div>

                <!-- Pillar 3: Breathable Comfort -->
                <div class="rounded-3xl bg-white border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative h-64 sm:h-72 w-full overflow-hidden flex items-center justify-center border-b border-slate-100" style="height: 280px; background-color: #f5f5f4;">
                        <img
                            src="{{ asset('images/library/bfd6ee1d-05ee-4024-b25f-2a68d5b77ab2.png') }}"
                            alt="SOX N SOX Breathable Comfort Airflow"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3 py-1 rounded-full text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-[#1d5b8f] border border-sky-200/60 shadow-xs">
                            Thermal Balance
                        </div>
                    </div>
                    <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#1d5b8f]"></span>
                                <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63]">Breathable Comfort</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                                Lightweight breathable fabrics help maintain airflow, dissipate moisture, and preserve foot freshness all day long.
                            </p>
                        </div>
                        <div class="pt-3 text-xs font-semibold text-[#1d5b8f] flex items-center gap-1.5 border-t border-slate-100">
                            <i class="fa-solid fa-circle-check text-xs"></i> Micro-ventilation cooling mesh
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: 4-STEP ENGINEERING ARCHITECTURE WITH INNOVATION DIAGRAMS -->
    <section class="py-16 sm:py-24 bg-[#f5f7fa] border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-16">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#fff4e8] text-[#f29a38] border border-[#f29a38]/25">
                    Step-by-Step Architecture
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    How We Engineer Unmatched Everyday Comfort
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                    From raw botanical fiber to hand-linked finishing, our 4-stage process guarantees unmatched foot relief:
                </p>
            </div>

            <!-- 4 Process Steps -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16 reveal-stagger">
                <!-- Step 01 -->
                <div class="group p-8 rounded-3xl bg-white border border-slate-200/90 space-y-4 hover:shadow-xl hover:-translate-y-2 hover:border-[#2ca7a3]/50 transition-all duration-300 shadow-xs relative">
                    <div class="flex items-center justify-between">
                        <div class="h-12 w-12 rounded-2xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300 shadow-xs">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <span class="font-display text-4xl font-black text-[#2ca7a3]/30 select-none">01</span>
                    </div>
                    <h3 class="font-display text-xl font-bold text-[#133b63]">Pure Bamboo Yarn</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Micro-porous fibers derived from cultivated bamboo grass. Inherently silky, moisture-wicking, hypoallergenic, and antibacterial.
                    </p>
                </div>

                <!-- Step 02 -->
                <div class="group p-8 rounded-3xl bg-white border border-slate-200/90 space-y-4 hover:shadow-xl hover:-translate-y-2 hover:border-[#f29a38]/50 transition-all duration-300 shadow-xs relative">
                    <div class="flex items-center justify-between">
                        <div class="h-12 w-12 rounded-2xl bg-[#fff4e8] text-[#f29a38] flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300 shadow-xs">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <span class="font-display text-4xl font-black text-[#f29a38]/30 select-none">02</span>
                    </div>
                    <h3 class="font-display text-xl font-bold text-[#133b63]">200-Needle Weave</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Medical-grade high-density circular knitting creates an ultra-fine mesh that resists abrasion and cradles the foot without bulk.
                    </p>
                </div>

                <!-- Step 03 -->
                <div class="group p-8 rounded-3xl bg-white border border-slate-200/90 space-y-4 hover:shadow-xl hover:-translate-y-2 hover:border-[#1d5b8f]/50 transition-all duration-300 shadow-xs relative">
                    <div class="flex items-center justify-between">
                        <div class="h-12 w-12 rounded-2xl bg-[#e9f2fa] text-[#1d5b8f] flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300 shadow-xs">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                        </div>
                        <span class="font-display text-4xl font-black text-[#1d5b8f]/30 select-none">03</span>
                    </div>
                    <h3 class="font-display text-xl font-bold text-[#133b63]">Non-Binding Grip</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Engineered honeycomb cuffs eliminate constricting bands, ensuring healthy circulation for diabetics, seniors, and active workers.
                    </p>
                </div>

                <!-- Step 04 -->
                <div class="group p-8 rounded-3xl bg-white border border-slate-200/90 space-y-4 hover:shadow-xl hover:-translate-y-2 hover:border-[#2ca7a3]/50 transition-all duration-300 shadow-xs relative">
                    <div class="flex items-center justify-between">
                        <div class="h-12 w-12 rounded-2xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300 shadow-xs">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <span class="font-display text-4xl font-black text-[#2ca7a3]/30 select-none">04</span>
                    </div>
                    <h3 class="font-display text-xl font-bold text-[#133b63]">Hand-Linked Toe</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        0mm completely seamless toe closure eliminates painful rubbing, corn friction, and blister development across 10,000+ daily steps.
                    </p>
                </div>
            </div>

            <!-- 3 Innovation Technical Diagram Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 reveal-stagger">
                <div class="group p-6 rounded-3xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300 flex items-center gap-5">
                    <div class="w-20 h-20 p-1.5 rounded-2xl overflow-hidden shrink-0 flex items-center justify-center border border-slate-200/80 shadow-xs" style="background-color: #f5f5f4;">
                        <img
                            src="{{ asset('images/about/tech-breathability.png') }}"
                            alt="Breathability Micro-Mesh Diagram"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                            loading="lazy"
                        />
                    </div>
                    <div>
                        <h4 class="font-display text-base font-bold text-[#133b63]">Micro-Mesh Airflow</h4>
                        <p class="text-xs text-[#6b7280] mt-1">Cross-woven channels pull moisture outward to keep skin dry in all climates.</p>
                    </div>
                </div>

                <div class="group p-6 rounded-3xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300 flex items-center gap-5">
                    <div class="w-20 h-20 p-1.5 rounded-2xl overflow-hidden shrink-0 flex items-center justify-center border border-slate-200/80 shadow-xs" style="background-color: #f8f7f6;">
                        <img
                            src="{{ asset('images/about/tech-arch-support.png') }}"
                            alt="360 Arch Support Diagram"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                            loading="lazy"
                        />
                    </div>
                    <div>
                        <h4 class="font-display text-base font-bold text-[#133b63]">360&deg; Arch Ribbing</h4>
                        <p class="text-xs text-[#6b7280] mt-1">Targeted elastic band wraps the midfoot to prevent slippage and stabilize the arch.</p>
                    </div>
                </div>

                <div class="group p-6 rounded-3xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#1d5b8f]/40 transition-all duration-300 flex items-center gap-5">
                    <div class="w-20 h-20 p-1.5 rounded-2xl overflow-hidden shrink-0 flex items-center justify-center border border-slate-200/80 shadow-xs" style="background-color: #f5f5f4;">
                        <img
                            src="{{ asset('images/about/tech-cushion.png') }}"
                            alt="Plush Terry Cushion Diagram"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                            loading="lazy"
                        />
                    </div>
                    <div>
                        <h4 class="font-display text-base font-bold text-[#133b63]">Terry Sole Cushion</h4>
                        <p class="text-xs text-[#6b7280] mt-1">Dense looped loops absorb floor impact and relieve heel pressure throughout the day.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: MADE FOR EVERY PART OF YOUR DAY (4 Authentic Lifestyle Cards) -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-14">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#e6f8f7] text-[#2ca7a3] border border-[#2ca7a3]/25">
                    Everyday Versatility
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Made For Every Part Of Your Day
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                    Designed to adapt seamlessly across your entire routine &mdash; from morning commutes to relaxed evenings:
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 reveal-stagger">
                <!-- Situation 1: At Work -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/library/7390a244-c8f3-4985-a66e-d51ef1a56abf.png') }}"
                            alt="SOX N SOX At Work"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-3 left-3 bg-[#133b63] text-white p-2 rounded-xl text-xs shadow-md">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-2">
                        <div>
                            <h3 class="font-display text-base font-bold text-[#133b63]">At Work</h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed mt-1">
                                Stay comfortable and focused through long standing and desk hours without tight calf pinch.
                            </p>
                        </div>
                        <span class="text-[11px] font-semibold text-[#2ca7a3] flex items-center gap-1">
                            <i class="fa-solid fa-check text-[10px]"></i> All-day polish &amp; support
                        </span>
                    </div>
                </div>

                <!-- Situation 2: While Travelling -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/library/713d1ba9-ac9c-4840-988f-c81181eb8cec.png') }}"
                            alt="SOX N SOX While Travelling"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-3 left-3 bg-[#2ca7a3] text-white p-2 rounded-xl text-xs shadow-md">
                            <i class="fa-solid fa-plane"></i>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-2">
                        <div>
                            <h3 class="font-display text-base font-bold text-[#133b63]">While Travelling</h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed mt-1">
                                Prevents swelling and heaviness during long flights, rail commutes, and road trips.
                            </p>
                        </div>
                        <span class="text-[11px] font-semibold text-[#2ca7a3] flex items-center gap-1">
                            <i class="fa-solid fa-check text-[10px]"></i> Healthy venous circulation
                        </span>
                    </div>
                </div>

                <!-- Situation 3: During Activities -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/library/db8bbd61-defa-4eec-a6d4-b2f4643ea9d3.png') }}"
                            alt="SOX N SOX During Activities"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-3 left-3 bg-[#f29a38] text-white p-2 rounded-xl text-xs shadow-md">
                            <i class="fa-solid fa-person-running"></i>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-2">
                        <div>
                            <h3 class="font-display text-base font-bold text-[#133b63]">During Activities</h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed mt-1">
                                Flexible dynamic support engineered for brisk walking, workouts, and outdoor routines.
                            </p>
                        </div>
                        <span class="text-[11px] font-semibold text-[#f29a38] flex items-center gap-1">
                            <i class="fa-solid fa-check text-[10px]"></i> Anti-blister friction guard
                        </span>
                    </div>
                </div>

                <!-- Situation 4: At Home -->
                <div class="rounded-3xl bg-[#f5f7fa] border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('images/library/9d5ab10e-17b0-4585-a38c-903910373c33.png') }}"
                            alt="SOX N SOX At Home"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute top-3 left-3 bg-[#1d5b8f] text-white p-2 rounded-xl text-xs shadow-md">
                            <i class="fa-solid fa-couch"></i>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-2">
                        <div>
                            <h3 class="font-display text-base font-bold text-[#133b63]">At Home</h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed mt-1">
                                Relax in cloud-soft breathable comfort designed for easy lounging and evening recovery.
                            </p>
                        </div>
                        <span class="text-[11px] font-semibold text-[#1d5b8f] flex items-center gap-1">
                            <i class="fa-solid fa-check text-[10px]"></i> Silky soothing touch
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: EVERYDAY COMFORT SOLUTIONS (Challenges vs Our Approach with Center Showcase Photo) -->
    <section class="py-16 sm:py-24 bg-[#f5f7fa] border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-16">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#fff4e8] text-[#f29a38] border border-[#f29a38]/25">
                    Everyday Comfort Solutions
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Designed Around Real Everyday Needs
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                    We solved the common pain points of traditional socks with deliberate, user-centered engineering:
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Left Column: Everyday Challenges (4 cards) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="p-3 bg-red-50 text-red-700 text-xs font-bold uppercase tracking-wider rounded-xl border border-red-200/50 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Everyday Foot Challenges</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5">
                        <span class="h-9 w-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-shoe-prints"></i>
                        </span>
                        <div>
                            <h4 class="font-display text-sm font-bold text-[#133b63]">Foot Fatigue</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Long hours standing or walking create plantar pressure, ache, and heaviness.</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5">
                        <span class="h-9 w-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-temperature-arrow-up"></i>
                        </span>
                        <div>
                            <h4 class="font-display text-sm font-bold text-[#133b63]">Heat &amp; Moisture</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Synthetic fabrics trap sweat and warmth, creating bad odors and skin maceration.</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5">
                        <span class="h-9 w-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-compress"></i>
                        </span>
                        <div>
                            <h4 class="font-display text-sm font-bold text-[#133b63]">Constricting Bands</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Tight elastic cuffs bite into the calf, leaving painful indentations and cutting circulation.</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5">
                        <span class="h-9 w-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-bandage"></i>
                        </span>
                        <div>
                            <h4 class="font-display text-sm font-bold text-[#133b63]">Toe Seam Friction</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Bulky ridged toe seams rub against toes, causing corns, blisters, and sores.</p>
                        </div>
                    </div>
                </div>

                <!-- Center Column: Center Showcase Photo from Original Site -->
                <div class="lg:col-span-4 relative">
                    <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-200 bg-white group">
                        <div class="pt-8 sm:pt-10 px-6 pb-2 flex items-center justify-center overflow-hidden">
                            <img
                                src="{{ asset('images/library/20de2e2f-3f60-47d5-99d2-8ca16aa8843b.png') }}"
                                alt="SOX N SOX The Solution in Action"
                                class="w-full h-auto object-contain max-h-[420px] group-hover:scale-105 transition-transform duration-700 ease-out"
                                loading="lazy"
                            />
                        </div>
                        <div class="p-5 bg-white text-center border-t border-slate-100">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#e6f8f7] text-[#2ca7a3]">
                                <i class="fa-solid fa-shield-halved"></i> 100% Engineered Solution
                            </span>
                            <h4 class="font-display text-base font-bold text-[#133b63] mt-2">Engineered For Human Feet</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Every millimeter designed to eliminate pressure and support active lives.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Our Comfort Approach (4 cards) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="p-3 bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold uppercase tracking-wider rounded-xl border border-[#2ca7a3]/30 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Our Comfort Approach</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5">
                        <span class="h-9 w-9 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-crosshairs"></i>
                        </span>
                        <div>
                            <h4 class="font-display text-sm font-bold text-[#133b63]">Supportive Design</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Dynamic arch band and cushioned terry footbed absorb walking impact effortlessly.</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5">
                        <span class="h-9 w-9 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-wind"></i>
                        </span>
                        <div>
                            <h4 class="font-display text-sm font-bold text-[#133b63]">Breathable Fabrics</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Porous bamboo fibers thermoregulate continuously, keeping feet 2&deg; cooler and odor-free.</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5">
                        <span class="h-9 w-9 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-feather"></i>
                        </span>
                        <div>
                            <h4 class="font-display text-sm font-bold text-[#133b63]">Non-Binding Honeycomb</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Gentle cross-woven cuffs stay up smoothly without digging into skin or restricting veins.</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5">
                        <span class="h-9 w-9 rounded-xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-link-slash"></i>
                        </span>
                        <div>
                            <h4 class="font-display text-sm font-bold text-[#133b63]">Seamless Hand-Linked Toe</h4>
                            <p class="text-xs text-[#6b7280] mt-0.5">Ultra-flat 0mm toe stitch completely eliminates pressure ridges and friction blisters.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 6: WHY SOX N SOX (6 Principles Grid) -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-14">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#e6f8f7] text-[#2ca7a3] border border-[#2ca7a3]/25">
                    Why SOX N SOX
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Designed Around Everyday Comfort
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                    A careful balance of craftsmanship, medical insight, and modern lifestyle styling:
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
                <!-- Principle 1 -->
                <div class="p-6 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 space-y-3 hover:shadow-lg hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center text-xl">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <h3 class="font-display text-lg font-bold text-[#133b63]">Soft Comfort</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Comfort-focused fabrics designed for soothing, friction-free all-day wear.
                    </p>
                </div>

                <!-- Principle 2 -->
                <div class="p-6 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 space-y-3 hover:shadow-lg hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-[#fff4e8] text-[#f29a38] flex items-center justify-center text-xl">
                        <i class="fa-solid fa-wind"></i>
                    </div>
                    <h3 class="font-display text-lg font-bold text-[#133b63]">Breathable Feel</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Lightweight airflow-friendly materials keep feet pleasantly fresh and dry.
                    </p>
                </div>

                <!-- Principle 3 -->
                <div class="p-6 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 space-y-3 hover:shadow-lg hover:-translate-y-1 hover:border-[#1d5b8f]/40 transition-all duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-[#e9f2fa] text-[#1d5b8f] flex items-center justify-center text-xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="font-display text-lg font-bold text-[#133b63]">Everyday Durability</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Reliable 200-needle high-density construction made for repeated daily use.
                    </p>
                </div>

                <!-- Principle 4 -->
                <div class="p-6 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 space-y-3 hover:shadow-lg hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center text-xl">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </div>
                    <h3 class="font-display text-lg font-bold text-[#133b63]">Flexible Fit</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Engineered to move naturally with your feet without slipping or sagging.
                    </p>
                </div>

                <!-- Principle 5 -->
                <div class="p-6 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 space-y-3 hover:shadow-lg hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-[#fff4e8] text-[#f29a38] flex items-center justify-center text-xl">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3 class="font-display text-lg font-bold text-[#133b63]">Daily Versatility</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Perfect across formal shoes, sneakers, boots, and relaxed home walking.
                    </p>
                </div>

                <!-- Principle 6 -->
                <div class="p-6 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 space-y-3 hover:shadow-lg hover:-translate-y-1 hover:border-[#1d5b8f]/40 transition-all duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-[#e9f2fa] text-[#1d5b8f] flex items-center justify-center text-xl">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3 class="font-display text-lg font-bold text-[#133b63]">Modern Lifestyle Design</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        A harmonious balance of ergonomic comfort, therapeutic benefit, and style.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 7: CTA -->
    <section class="py-16 sm:py-24 bg-[#f5f7fa] reveal-on-scroll">
        <div class="site-container text-center">
            <div class="max-w-3xl mx-auto space-y-6">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#e6f8f7] text-[#2ca7a3] border border-[#2ca7a3]/25">
                    Ready For Real Comfort?
                </span>

                <h2 class="font-display text-2xl sm:text-4xl lg:text-5xl font-extrabold text-[#133b63] leading-tight">
                    Feel The SOX N SOX Difference In Every Step
                </h2>

                <div class="soxnsox-decorative-line-center my-4"></div>

                <p class="text-base sm:text-lg leading-relaxed text-[#6b7280] max-w-2xl mx-auto">
                    Experience 2x softer bamboo yarn, non-binding cuffs, and 0mm seamless toe defense crafted for your real daily life.
                </p>

                <div class="pt-6 flex flex-wrap justify-center gap-4">
                    <a
                        href="{{ route('shop.products.index') }}"
                        class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 inline-flex items-center gap-2 px-8 py-4 text-xs font-bold uppercase tracking-widest rounded-full shadow-lg hover:shadow-xl transition-all duration-300"
                    >
                        <span>Shop All Socks</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>

                    <a
                        href="{{ route('shop.home.contact_us') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 text-xs font-bold uppercase tracking-widest rounded-full border border-slate-300 bg-white text-[#133b63] hover:bg-slate-50 hover:border-[#2ca7a3]/50 transition-all duration-300 active:scale-95 shadow-xs hover:shadow-md"
                    >
                        <span>Contact Us</span>
                        <i class="fa-solid fa-headset text-xs text-[#2ca7a3]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
