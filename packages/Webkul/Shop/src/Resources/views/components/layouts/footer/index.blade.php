{!! view_render_event('bagisto.shop.layout.footer.before') !!}

@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

@php
    $channel = core()->getCurrentChannel();
    $logoConfig = core()->getConfigData('general.design.admin_logo.logo_image');
    $logoUrl = $channel->logo_url ?: ($logoConfig ? \Illuminate\Support\Facades\Storage::url($logoConfig) : null);

    $customization = $themeCustomizationRepository->findOneWhere([
        'type'       => 'footer_links',
        'status'     => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);

    $socialLinks = $customization->options['social_links'] ?? [
        'instagram' => 'https://instagram.com/soxnsox',
        'youtube'   => 'https://youtube.com/@soxnsox',
        'linkedin'  => 'https://linkedin.com/company/soxnsox',
        'twitter'   => 'https://twitter.com/soxnsox',
        'facebook'  => 'https://facebook.com/soxnsox',
    ];

    $copyrightContent = core()->getConfigData('general.content.footer.copyright_content') ?: '&copy; ' . date('Y') . ' SOX N SOX. India\'s Premier Bamboo & Diabetic Socks. All rights reserved.';
    $whiteLogoUrl = file_exists(public_path('storage/channel/1/logo_white.png'))
        ? asset('storage/channel/1/logo_white.png')
        : (file_exists(public_path('logo-white.png')) ? asset('logo-white.png') : null);
@endphp

<footer 
    class="w-full overflow-hidden" 
    style="background: linear-gradient(180deg, #133b63 0%, #0c243d 100%) !important; color: #f5f7fa !important; border-top: 1px solid rgba(44, 167, 163, 0.3) !important; font-family: 'Poppins', sans-serif !important;"
>
    <!-- Main Footer Content -->
    <div class="site-container w-full" style="padding-top: 4.5rem; padding-bottom: 4rem;">
        <div class="soxnsox-footer-grid">
            
            <!-- Brand Column -->
            <div class="soxnsox-footer-col-brand lg:pr-4" style="display: flex; flex-direction: column; gap: 1.25rem;">
                <a href="{{ route('shop.home.index') }}" class="inline-block group" style="text-decoration: none;">
                    @if ($whiteLogoUrl)
                        <img
                            src="{{ $whiteLogoUrl }}"
                            alt="SOX N SOX - India's Premier Bamboo &amp; Diabetic Socks"
                            class="h-9 md:h-10 w-auto object-contain max-w-[190px] opacity-95 transition-opacity group-hover:opacity-100"
                        />
                    @elseif ($logoUrl)
                        <img
                            src="{{ $logoUrl }}"
                            alt="SOX N SOX - India's Premier Bamboo &amp; Diabetic Socks"
                            class="h-9 md:h-10 w-auto object-contain max-w-[190px] brightness-0 invert opacity-95 transition-opacity group-hover:opacity-100"
                        />
                    @else
                        <span style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 900; color: #ffffff; letter-spacing: -0.03em;">
                            SOX<span style="color: #f29a38;">N</span>SOX
                        </span>
                        <span style="display: block; font-size: 0.625rem; letter-spacing: 0.32em; text-transform: uppercase; color: #2ca7a3; font-weight: 700; margin-top: 0.2rem;">
                            Bamboo Socks
                        </span>
                    @endif
                </a>

                <p style="font-size: 0.8125rem; line-height: 1.65; color: rgba(245, 247, 250, 0.75); max-width: 360px; margin: 0;">
                    India's premier bamboo socks brand. Crafted with sustainable bamboo fiber for superior breathability, natural antibacterial odour defense, seamless blister protection, and medical-grade diabetic comfort.
                </p>

                <!-- Sock Quality Badges -->
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; padding-top: 0.25rem;">
                    <span style="background: rgba(44, 167, 163, 0.15); color: #2ca7a3; border: 1px solid rgba(44, 167, 163, 0.35); padding: 0.35rem 0.85rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.04em;">
                        100% Pure Bamboo
                    </span>
                    <span style="background: rgba(242, 154, 56, 0.15); color: #f29a38; border: 1px solid rgba(242, 154, 56, 0.35); padding: 0.35rem 0.85rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.04em;">
                        Seamless Hand-Linked Toe
                    </span>
                    <span style="background: rgba(29, 91, 143, 0.25); color: #8bc2f0; border: 1px solid rgba(29, 91, 143, 0.45); padding: 0.35rem 0.85rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.04em;">
                        Diabetic Friendly
                    </span>
                </div>
            </div>

            <!-- Column 1: Collections -->
            <div class="soxnsox-footer-col" style="display: flex; flex-direction: column;">
                <h3 class="soxnsox-footer-heading text-[#f29a38]">
                    Collections
                </h3>
                <div class="soxnsox-footer-accent-line soxnsox-accent-amber"></div>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li><a href="{{ route('shop.category.view', 'medical-socks') }}" class="hover:text-[#2ca7a3] hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Medical &amp; Diabetic</a></li>
                    <li><a href="{{ route('shop.category.view', 'men') }}" class="hover:text-[#2ca7a3] hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Men's Bamboo Socks</a></li>
                    <li><a href="{{ route('shop.category.view', 'women') }}" class="hover:text-[#2ca7a3] hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Women's Active &amp; Gym</a></li>
                    <li><a href="{{ route('shop.category.view', 'children') }}" class="hover:text-[#2ca7a3] hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Kids &amp; Baby Socks</a></li>
                    <li><a href="{{ route('shop.products.index') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5" style="color: #f29a38; font-size: 0.8125rem; font-weight: 700; text-decoration: none;"><span>Shop All Styles</span> <i class="fa-solid fa-arrow-right text-[11px]"></i></a></li>
                </ul>
            </div>

            <!-- Column 2: The Bamboo Science -->
            <div class="soxnsox-footer-col" style="display: flex; flex-direction: column;">
                <h3 class="soxnsox-footer-heading text-[#2ca7a3]">
                    About &amp; Technology
                </h3>
                <div class="soxnsox-footer-accent-line soxnsox-accent-teal"></div>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li><a href="{{ route('shop.cms.page', 'about-us') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">About Us</a></li>
                    <li><a href="{{ route('shop.blogs.index') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Foot Wellness Blog</a></li>
                    <li><a href="{{ route('shop.cms.page', 'why-choose-us') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Why Choose Us</a></li>
                    <li><a href="{{ route('shop.cms.page', 'how-it-works') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">How It Works</a></li>
                    <li><a href="{{ route('shop.home.contact_us') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Contact Us</a></li>
                    <li><a href="{{ route('shop.cms.page', 'quality') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Quality Guarantee</a></li>
                </ul>
            </div>

            <!-- Column 3: Customer Care -->
            <div class="soxnsox-footer-col" style="display: flex; flex-direction: column;">
                <h3 class="soxnsox-footer-heading text-[#f29a38]">
                    Customer Care
                </h3>
                <div class="soxnsox-footer-accent-line soxnsox-accent-amber"></div>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li><a href="{{ route('shop.cms.page', 'shipping-policy') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Shipping &amp; Delivery</a></li>
                    <li><a href="{{ route('shop.cms.page', 'return-policy') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">7-Day Easy Returns</a></li>
                    <li><a href="{{ route('shop.cms.page', 'terms-conditions') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Terms of Service</a></li>
                    <li><a href="{{ route('shop.cms.page', 'privacy-policy') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">Privacy Policy</a></li>
                    @if (core()->getConfigData('general.sitemap.settings.enabled') ?? true)
                        <li><a href="{{ route('shop.sitemap.index') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block" style="color: rgba(245, 247, 250, 0.85); font-size: 0.8125rem; text-decoration: none;">XML Sitemap</a></li>
                    @endif
                </ul>
            </div>

            <!-- Column 4: Newsletter & Community -->
            <div class="soxnsox-footer-col-newsletter" style="display: flex; flex-direction: column;">
                <h3 class="soxnsox-footer-heading text-[#2ca7a3]">
                    Sock Club
                </h3>
                <div class="soxnsox-footer-accent-line soxnsox-accent-teal"></div>

                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    <p style="font-size: 0.75rem; line-height: 1.5; color: rgba(245, 247, 250, 0.75); margin: 0;">
                        Get 10% off your first pack and exclusive access to new seasonal releases.
                    </p>

                    <form
                        action="{{ route('shop.subscription.store') }}"
                        method="POST"
                        style="display: flex; flex-direction: column; gap: 0.5rem;"
                    >
                        @csrf
                        <input
                            type="email"
                            name="email"
                            required
                            placeholder="Enter your email"
                            style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(44, 167, 163, 0.4); color: #ffffff; border-radius: 9999px; height: 40px; padding: 0 1.25rem; font-size: 0.75rem; width: 100%; box-sizing: border-box; outline: none;"
                        />
                        <button
                            type="submit"
                            class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 transition-all duration-300"
                            style="height: 40px; width: 100%; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; border-radius: 9999px;"
                        >
                            Subscribe &amp; Save
                        </button>
                    </form>

                    <!-- Social Channels -->
                    <div style="padding-top: 0.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.65rem;">
                            <a href="https://instagram.com" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 9999px; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(44, 167, 163, 0.3); color: #f5f7fa; text-decoration: none;" class="hover:bg-[#2ca7a3] hover:text-white hover:scale-110 active:scale-95 transition-all duration-300" aria-label="Instagram">
                                <i class="fa-brands fa-instagram text-sm"></i>
                            </a>
                            <a href="https://facebook.com" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 9999px; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(44, 167, 163, 0.3); color: #f5f7fa; text-decoration: none;" class="hover:bg-[#1d5b8f] hover:text-white hover:scale-110 active:scale-95 transition-all duration-300" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f text-sm"></i>
                            </a>
                            <a href="https://youtube.com" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 9999px; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(44, 167, 163, 0.3); color: #f5f7fa; text-decoration: none;" class="hover:bg-[#f29a38] hover:text-white hover:scale-110 active:scale-95 transition-all duration-300" aria-label="YouTube">
                                <i class="fa-brands fa-youtube text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div style="background-color: #0b1e32 !important; border-top: 1px solid rgba(44, 167, 163, 0.2) !important; padding: 1.25rem 0 !important;">
        <div class="site-container flex flex-col md:flex-row items-center justify-between gap-4 text-xs" style="color: rgba(245, 247, 250, 0.65) !important;">
            {!! view_render_event('bagisto.shop.layout.footer.footer_text.before') !!}

            <p class="text-center md:text-left text-xs m-0">
                &copy; {{ date('Y') }} SOX N SOX. All Rights Reserved. Crafted with 100% Pure Bamboo.
            </p>

            <div class="flex items-center gap-4 text-[11px]" style="color: rgba(245, 247, 250, 0.6) !important;">
                <a href="{{ route('shop.cms.page', 'privacy-policy') }}" class="hover:text-[#f29a38] transition-colors" style="color: inherit; text-decoration: none;">Privacy</a>
                <span class="soxnsox-footer-dot"></span>
                <a href="{{ route('shop.cms.page', 'terms-conditions') }}" class="hover:text-[#f29a38] transition-colors" style="color: inherit; text-decoration: none;">Terms</a>
                <span class="soxnsox-footer-dot"></span>
                <a href="{{ route('shop.cms.page', 'shipping-policy') }}" class="hover:text-[#f29a38] transition-colors" style="color: inherit; text-decoration: none;">Shipping</a>
                @if (core()->getConfigData('general.sitemap.settings.enabled') ?? true)
                    <span class="soxnsox-footer-dot"></span>
                    <a href="{{ route('shop.sitemap.index') }}" class="hover:text-[#f29a38] transition-colors" style="color: inherit; text-decoration: none;">Sitemap</a>
                @endif
            </div>

            {!! view_render_event('bagisto.shop.layout.footer.footer_text.after') !!}
        </div>
    </div>
</footer>

{!! view_render_event('bagisto.shop.layout.footer.after') !!}
