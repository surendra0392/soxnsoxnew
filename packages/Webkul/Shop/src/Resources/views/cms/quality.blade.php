<div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
    @if (core()->getConfigData('general.general.breadcrumbs.shop'))
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <span class="text-[#133b63] font-semibold">Quality Standard</span>
            </nav>
        </div>
    @endif

    <!-- SECTION 1: HERO & QUALITY STANDARD -->
    <section class="site-container pt-8 pb-16 sm:pt-14 sm:pb-20 border-b border-slate-200 reveal-on-scroll">
        <div class="max-w-3xl mx-auto text-center space-y-5 mb-8">
            <!-- Brand Tagline Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-xs font-bold tracking-widest uppercase border border-[#2ca7a3]/25 shadow-xs">
                <i class="fa-solid fa-shield-halved text-[#2ca7a3] text-sm"></i>
                <span>The SOX N SOX Quality Standard</span>
            </div>

            <!-- Main Heading -->
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#133b63] leading-[1.14]">
                Precision Engineering. <br class="hidden sm:inline">
                <span class="text-[#f29a38]">Uncompromised Foot Health.</span>
            </h1>

            <div class="soxnsox-decorative-line-center my-4"></div>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg lg:text-xl leading-relaxed text-[#6b7280]">
                Quality is not an afterthought — it is engineered into every stitch. From fine 200-needle high-density knitting to hand-linked seamless toes and OEKO-TEX certified yarns, discover why SOX N SOX is India's foot health benchmark.
            </p>
        </div>

        <!-- 4 Trust Metrics Strip (Full site-container width) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 pt-6 text-left reveal-stagger">
            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300">
                <p class="font-display text-3xl font-extrabold text-[#133b63]">200</p>
                <p class="text-xs uppercase tracking-wider text-[#2ca7a3] font-bold mt-1">Needle Density</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Ultra-fine stitch density for maximum durability &amp; softness.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#f29a38]/40 transition-all duration-300">
                <p class="font-display text-3xl font-extrabold text-[#133b63]">0 mm</p>
                <p class="text-xs uppercase tracking-wider text-[#f29a38] font-bold mt-1">Toe Ridge Height</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Hand-linked flat toe closure with zero friction ridges.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#1d5b8f]/40 transition-all duration-300">
                <p class="font-display text-3xl font-extrabold text-[#133b63]">50+</p>
                <p class="text-xs uppercase tracking-wider text-[#1d5b8f] font-bold mt-1">Wash Cycles Tested</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">Maintains fiber elasticity and softness without pill formation.</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#2ca7a3]/40 transition-all duration-300">
                <p class="font-display text-3xl font-extrabold text-[#133b63]">100%</p>
                <p class="text-xs uppercase tracking-wider text-[#2ca7a3] font-bold mt-1">Non-Toxic Dyes</p>
                <p class="text-[11px] text-[#6b7280] mt-0.5">OEKO-TEX safe colors free from azo dyes and formaldehyde.</p>
            </div>
        </div>
    </section>

    <!-- SECTION 2: 4 PILLARS OF FOOTWEAR INNOVATION -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-16">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-[#e6f8f7] text-[#2ca7a3] border border-[#2ca7a3]/25">
                    Lab-Tested Science
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63] leading-tight">
                    Engineered For Sensitive &amp; Diabetic Feet
                </h2>
                <div class="soxnsox-decorative-line-center my-4"></div>
                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-xl mx-auto">
                    Diabetic foot complications often begin with minor friction, pressure points, and moisture. Our designs solve each problem at the molecular and mechanical level.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10 reveal-stagger">
                <!-- Pillar 1 -->
                <div class="p-8 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 shadow-sm space-y-4 hover:shadow-xl hover:-translate-y-1.5 hover:border-[#2ca7a3]/40 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#e6f8f7] text-[#2ca7a3]">
                            <i class="fa-solid fa-leaf text-xl"></i>
                        </span>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">Yarn Purity</span>
                            <h3 class="font-display text-xl font-bold text-[#133b63]">100% Bamboo Fiber</h3>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Bamboo fibers are round and smooth at the microscopic level with no sharp spurs, making them naturally anti-static and non-abrasive. Even for people with severe neuropathy or delicate skin, our fabric provides a cloud-like second skin.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="p-8 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 shadow-sm space-y-4 hover:shadow-xl hover:-translate-y-1.5 hover:border-[#f29a38]/40 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#fff4e8] text-[#f29a38]">
                            <i class="fa-solid fa-heart-pulse text-xl"></i>
                        </span>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#f29a38]">Circulation First</span>
                            <h3 class="font-display text-xl font-bold text-[#133b63]">Non-Binding Soft Grip Cuff</h3>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Conventional socks use tight elastic rings that act like tourniquets, restricting arterial flow to the extremities. SOX N SOX uses an ultra-wide rib knit with graduated micro-tension that stays upright without squeezing or leaving marks.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="p-8 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 shadow-sm space-y-4 hover:shadow-xl hover:-translate-y-1.5 hover:border-[#1d5b8f]/40 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#e9f2fa] text-[#1d5b8f]">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </span>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#1d5b8f]">Friction Shield</span>
                            <h3 class="font-display text-xl font-bold text-[#133b63]">Hand-Linked Seamless Toe</h3>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Every single toe seam is closed stitch by stitch using hand-linking machinery. The result is a completely flat inside seam with 0mm ridge height, preventing painful blisters, corns, and calluses in the toe box.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="p-8 rounded-3xl bg-[#f5f7fa] border border-slate-200/90 shadow-sm space-y-4 hover:shadow-xl hover:-translate-y-1.5 hover:border-[#2ca7a3]/40 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#e6f8f7] text-[#2ca7a3]">
                            <i class="fa-solid fa-wind text-xl"></i>
                        </span>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">Natural Defense</span>
                            <h3 class="font-display text-xl font-bold text-[#133b63]">Bamboo Kun Antibacterial Action</h3>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Unlike synthetic socks treated with chemical antibacterial washes that rinse out after 5 washes, bamboo possesses a natural bio-agent called "Bamboo Kun" that remains permanently active, preventing 99.8% of bacterial odor growth.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: PROTOCOL & CERTIFICATIONS -->
    <section class="py-16 sm:py-24 bg-[#f5f7fa] reveal-on-scroll">
        <div class="site-container">
            <div class="max-w-4xl mx-auto rounded-3xl bg-white border border-slate-200 p-8 sm:p-14 shadow-sm text-center space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#fff4e8] text-[#f29a38] text-xs font-bold tracking-widest uppercase">
                    Our Quality Promise
                </div>

                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-[#133b63]">
                    100% Satisfaction Guarantee
                </h2>

                <div class="soxnsox-decorative-line-center my-4"></div>

                <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed max-w-2xl mx-auto">
                    Try SOX N SOX risk-free. If you do not agree that our bamboo socks are the softest, most comfortable socks you have ever worn, contact our care desk within 7 days for an effortless refund or exchange.
                </p>

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
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
                        <span>Contact Quality Team</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
