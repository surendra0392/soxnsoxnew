<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoxnsoxConfigSeeder extends Seeder
{
    /**
     * Seed SOXNSOX store core configuration, Indian Rupee (INR / ₹), Telangana defaults,
     * carrier settings, weight unit, and SOXNSOX branding assets.
     */
    public function run(): void
    {
        $this->command->info('=== SOXNSOX Core Configuration & Branding Seeder ===');

        $now = Carbon::now();

        // 1. Ensure INR is configured as the primary currency
        DB::table('currencies')->updateOrInsert(
            ['code' => 'INR'],
            [
                'name' => 'Indian Rupee',
                'symbol' => '₹',
                'decimal' => 2,
                'group_separator' => ',',
                'decimal_separator' => '.',
                'currency_position' => 'left',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $inrCurrency = DB::table('currencies')->where('code', 'INR')->first();
        $inrCurrencyId = $inrCurrency ? $inrCurrency->id : 1;

        // 2. Prepare Branding Asset directories in storage
        $publicAdminDir = storage_path('app/public/admin');
        if (! file_exists($publicAdminDir)) {
            mkdir($publicAdminDir, 0777, true);
        }
        $publicChannelDir = storage_path('app/public/channel/1');
        if (! file_exists($publicChannelDir)) {
            mkdir($publicChannelDir, 0777, true);
        }

        // Copy Official Soxnsox Branding Assets from repository to storage
        $brandRepoDir = base_path('packages/Webkul/Installer/src/Resources/assets/images/seeders/brand');
        $logoSrc = $brandRepoDir.'/soxnsox_logo_horizontal.png';
        $logoWhiteSrc = $brandRepoDir.'/soxnsox_logo_white.png';
        $iconSrc = $brandRepoDir.'/soxnsox_icon.png';
        $faviconIcoSrc = $brandRepoDir.'/favicon.ico';
        $badgeSrc = $brandRepoDir.'/soxnsox_app_badge.png';

        // Also ensure public storage symlink directories exist
        $pubChannel1 = public_path('storage/channel/1');
        $pubAdmin = public_path('storage/admin');
        if (! file_exists($pubChannel1)) {
            mkdir($pubChannel1, 0777, true);
        }
        if (! file_exists($pubAdmin)) {
            mkdir($pubAdmin, 0777, true);
        }

        // 1. Color Horizontal Logo
        if (file_exists($logoSrc)) {
            copy($logoSrc, $publicAdminDir.'/logo.png');
            copy($logoSrc, $publicChannelDir.'/logo.png');
            copy($logoSrc, $pubAdmin.'/logo.png');
            copy($logoSrc, $pubChannel1.'/logo.png');
            copy($logoSrc, public_path('logo.png'));
        }

        // 2. White Horizontal Logo (for footer & dark surfaces)
        if (file_exists($logoWhiteSrc)) {
            copy($logoWhiteSrc, $publicAdminDir.'/logo_white.png');
            copy($logoWhiteSrc, $publicChannelDir.'/logo_white.png');
            copy($logoWhiteSrc, $pubAdmin.'/logo_white.png');
            copy($logoWhiteSrc, $pubChannel1.'/logo_white.png');
            copy($logoWhiteSrc, public_path('logo-white.png'));
        }

        // 3. Circular Sock Emblem Favicon & App Icon
        if (file_exists($iconSrc)) {
            copy($iconSrc, $publicAdminDir.'/favicon.png');
            copy($iconSrc, $publicChannelDir.'/favicon.png');
            copy($iconSrc, $pubAdmin.'/favicon.png');
            copy($iconSrc, $pubChannel1.'/favicon.png');
            copy($iconSrc, public_path('favicon.png'));
            copy($iconSrc, public_path('apple-touch-icon.png'));
        }

        // 4. Multi-resolution Favicon ICO
        if (file_exists($faviconIcoSrc)) {
            copy($faviconIcoSrc, $publicAdminDir.'/favicon.ico');
            copy($faviconIcoSrc, $publicChannelDir.'/favicon.ico');
            copy($faviconIcoSrc, $pubAdmin.'/favicon.ico');
            copy($faviconIcoSrc, $pubChannel1.'/favicon.ico');
            copy($faviconIcoSrc, public_path('favicon.ico'));
        }

        // 5. App Badge
        if (file_exists($badgeSrc)) {
            copy($badgeSrc, $publicChannelDir.'/app_badge.png');
            copy($badgeSrc, $pubChannel1.'/app_badge.png');
        }

        // 6. Clean up legacy/placeholder SVG files from storage to prevent conflicts
        @unlink($publicAdminDir.'/logo.svg');
        @unlink($publicChannelDir.'/logo.svg');
        @unlink($pubAdmin.'/logo.svg');
        @unlink($pubChannel1.'/logo.svg');
        @unlink($publicAdminDir.'/favicon.svg');
        @unlink($publicChannelDir.'/favicon.svg');
        @unlink($pubAdmin.'/favicon.svg');
        @unlink($pubChannel1.'/favicon.svg');

        // 3. Set Channel 1 base currency, hostname, logo, and favicon
        DB::table('channels')->where('id', 1)->update([
            'theme' => 'default',
            'hostname' => config('app.url') ? parse_url(config('app.url'), PHP_URL_HOST) : null,
            'base_currency_id' => $inrCurrencyId,
            'logo' => 'channel/1/logo.png',
            'favicon' => 'channel/1/favicon.png',
        ]);

        DB::table('channel_currencies')->updateOrInsert(
            [
                'channel_id' => 1,
                'currency_id' => $inrCurrencyId,
            ]
        );

        // Remove non-INR currencies from default channel
        DB::table('channel_currencies')
            ->where('channel_id', 1)
            ->where('currency_id', '!=', $inrCurrencyId)
            ->delete();

        // 4. Define Core Config Key-Value Pairs with exact channel & locale scoping
        $configs = [
            // Admin Logo & Favicon
            [
                'code' => 'general.design.admin_logo.logo_image',
                'value' => 'admin/logo.png',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'general.design.admin_logo.favicon',
                'value' => 'admin/favicon.png',
                'channel_code' => null,
                'locale_code' => null,
            ],

            // Top Header Announcement & Offer Configuration (Rupee ₹499)
            [
                'code' => 'general.content.header_offer.title',
                'value' => 'FREE SHIPPING ON ORDERS OVER ₹499 • 100% BAMBOO SOCKS • DOCTOR-APPROVED DIABETIC FIT',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'general.content.header_offer.redirection_title',
                'value' => 'SHOP NOW',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'general.content.header_offer.redirection_link',
                'value' => '/products',
                'channel_code' => null,
                'locale_code' => null,
            ],

            // Footer Copyright (Locale-based: en)
            [
                'code' => 'general.content.footer.copyright_content',
                'value' => 'Copyright &copy; '.date('Y').' SOX N SOX — India\'s Premier Bamboo Socks. All rights reserved.',
                'channel_code' => null,
                'locale_code' => 'en',
            ],

            // Email & Customer Care Settings (Channel-based: default)
            [
                'code' => 'emails.configure.email_settings.sender_name',
                'value' => 'SOX N SOX Customer Care',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'emails.configure.email_settings.sender_email',
                'value' => 'support@soxnsox.in',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'emails.configure.email_settings.admin_name',
                'value' => 'SOXNSOX Sales Team',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'emails.configure.email_settings.admin_email',
                'value' => 'sales@soxnsox.in',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'emails.configure.email_settings.contact_name',
                'value' => 'SOXNSOX Customer Care',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'emails.configure.email_settings.contact_email',
                'value' => 'support@soxnsox.in',
                'channel_code' => 'default',
                'locale_code' => null,
            ],

            // Shipping Origin (ALEAP Industrial Estate, Hyderabad, Telangana, India)
            [
                'code' => 'sales.shipping.origin.address',
                'value' => 'Involute Institute of Industrial Training, Shed No 1,Survy No342, ALEAP Industrial Estate, Gajularamaram, Road Number 10, Pragathi Nagar',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'code' => 'sales.shipping.origin.address1',
                'value' => 'Involute Institute of Industrial Training, Shed No 1,Survy No342, ALEAP Industrial Estate, Gajularamaram, Road Number 10, Pragathi Nagar',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'sales.shipping.origin.city',
                'value' => 'Hyderabad, Medchal Malkajgiri',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'code' => 'sales.shipping.origin.city',
                'value' => 'Hyderabad, Medchal Malkajgiri',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'sales.shipping.origin.state',
                'value' => 'Telangana',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'code' => 'sales.shipping.origin.state',
                'value' => 'Telangana',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'sales.shipping.origin.zipcode',
                'value' => '500090',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'code' => 'sales.shipping.origin.zipcode',
                'value' => '500090',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'sales.shipping.origin.country',
                'value' => 'IN',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'code' => 'sales.shipping.origin.country',
                'value' => 'IN',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'sales.shipping.origin.store_name',
                'value' => 'SOX N SOX Fulfillment Center',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],

            // Taxes Default Destination (Telangana, India)
            [
                'code' => 'sales.taxes.default_destination_calculation.country',
                'value' => 'IN',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'sales.taxes.default_destination_calculation.state',
                'value' => 'TG',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'sales.taxes.default_destination_calculation.post_code',
                'value' => '500090',
                'channel_code' => null,
                'locale_code' => null,
            ],

            // Minimum Order Settings
            [
                'code' => 'sales.order_settings.minimum_order.enable',
                'value' => '1',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'sales.order_settings.minimum_order.minimum_order_amount',
                'value' => '499',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.order_settings.minimum_order.description',
                'value' => 'Complimentary express shipping applies on all orders above ₹499.',
                'channel_code' => 'default',
                'locale_code' => null,
            ],

            // Shipping Carriers: Flat Rate (channel: default, locale: en)
            [
                'code' => 'sales.carriers.flatrate.active',
                'value' => '1',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.carriers.flatrate.title',
                'value' => 'Standard Express Delivery',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'code' => 'sales.carriers.flatrate.description',
                'value' => 'Reliable door-to-door express courier delivery across India.',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'code' => 'sales.carriers.flatrate.default_rate',
                'value' => '50',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.carriers.flatrate.type',
                'value' => 'per_order',
                'channel_code' => 'default',
                'locale_code' => null,
            ],

            // Shipping Carriers: Free Shipping (channel: default, locale: en)
            [
                'code' => 'sales.carriers.free.active',
                'value' => '1',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.carriers.free.title',
                'value' => 'Complimentary Express Delivery (Orders > ₹499)',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'code' => 'sales.carriers.free.description',
                'value' => 'Free priority dispatch for all orders of ₹499 and above.',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],

            // Units & Catalog Options (Weight Unit: grams)
            [
                'code' => 'general.general.locale_options.weight_unit',
                'value' => 'grams',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'catalog.products.settings.compare_option',
                'value' => '1',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'customer.settings.wishlist.wishlist_option',
                'value' => '1',
                'channel_code' => null,
                'locale_code' => null,
            ],
            [
                'code' => 'general.general.breadcrumbs.shop',
                'value' => '1',
                'channel_code' => null,
                'locale_code' => null,
            ],
            // Social Login - Disabled
            [
                'code' => 'customer.settings.social_login.enable_facebook',
                'value' => '0',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'customer.settings.social_login.enable_twitter',
                'value' => '0',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'customer.settings.social_login.enable_google',
                'value' => '0',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'customer.settings.social_login.enable_linkedin',
                'value' => '0',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'customer.settings.social_login.enable_github',
                'value' => '0',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            // Razorpay Payment Gateway (Live Credentials)
            [
                'code' => 'sales.payment_methods.razorpay.active',
                'value' => '1',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.sandbox',
                'value' => '0',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.client_id',
                'value' => 'rzp_live_Sv7HztStWsQKPE',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.client_secret',
                'value' => 'jjAs7N9hPz7QdSR5lEPwgkfw',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.test_client_id',
                'value' => 'rzp_live_Sv7HztStWsQKPE',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.test_client_secret',
                'value' => 'jjAs7N9hPz7QdSR5lEPwgkfw',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.title',
                'value' => 'Razorpay (UPI, Cards, NetBanking, Wallets)',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.description',
                'value' => 'Pay securely using UPI (Google Pay, PhonePe, Paytm), Credit/Debit Cards, or NetBanking.',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.merchant_name',
                'value' => 'SOX N SOX',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.merchant_desc',
                'value' => 'Premium Bamboo & Diabetic Socks',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
            [
                'code' => 'sales.payment_methods.razorpay.sort',
                'value' => '1',
                'channel_code' => 'default',
                'locale_code' => null,
            ],
        ];

        foreach ($configs as $config) {
            DB::table('core_config')->updateOrInsert(
                [
                    'code' => $config['code'],
                    'channel_code' => $config['channel_code'],
                    'locale_code' => $config['locale_code'],
                ],
                [
                    'value' => $config['value'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // 5. Update Channel Details and Home SEO
        DB::table('channel_translations')->where('channel_id', 1)->where('locale', 'en')->update([
            'name' => 'SOX N SOX',
            'home_seo' => json_encode([
                'meta_title' => 'SOX N SOX — Super Soft Bamboo & Diabetic Socks',
                'meta_keywords' => 'bamboo socks, diabetic socks, seamless toe socks, odor resistant socks, bamboo ankle socks, doctor approved socks',
                'meta_description' => 'Shop SOX N SOX: India\'s premier bamboo and diabetic socks. Engineered with seamless blister protection, non-binding cuffs, and 2x softer breathable comfort.',
            ]),
        ]);

        $this->command->info('SOXNSOX Core Configuration & Channel SEO seeded successfully.');
    }
}
