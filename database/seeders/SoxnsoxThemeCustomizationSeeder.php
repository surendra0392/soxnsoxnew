<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoxnsoxThemeCustomizationSeeder extends Seeder
{
    /**
     * Seed SOXNSOX theme customizations.
     */
    public function run(): void
    {
        $this->command->info('=== SOXNSOX Theme Customization Seeder ===');

        $now = Carbon::now();

        // 1. Deactivate default Bagisto demo theme carousels and static blocks
        DB::table('theme_customizations')
            ->whereIn('id', [1, 2, 3, 4, 5, 6, 9, 10, 11, 12, 13, 14, 16])
            ->update(['status' => 0]);

        // 2. Define SOXNSOX Custom Theme Blocks
        $customizations = [
            [
                'id' => 18,
                'theme_code' => 'default',
                'type' => 'static_content',
                'name' => 'SOXNSOX Header Navigation',
                'sort_order' => 10,
                'status' => 1,
                'channel_id' => 1,
                'options' => json_encode([
                    'css' => '',
                    'html' => '<nav class="flex items-center gap-6 lg:gap-8" aria-label="Primary Navigation">
    <a href="/products" class="soxnsox-nav-link">
        All Socks
    </a>
    <a href="/medical-socks" class="soxnsox-nav-link flex items-center gap-1.5">
        <span class="inline-block w-2 h-2 rounded-full bg-[#2ca7a3] animate-pulse"></span>
        <span>Medical &amp; Diabetic</span>
    </a>
    <a href="/men" class="soxnsox-nav-link">
        Men
    </a>
    <a href="/women" class="soxnsox-nav-link">
        Women
    </a>
    <a href="/children" class="soxnsox-nav-link">
        Children
    </a>
    <a href="/#why-bamboo" class="soxnsox-nav-link text-[#f29a38] font-bold">
        Why Bamboo?
    </a>
</nav>',
                ]),
            ],
            [
                'id' => 19,
                'theme_code' => 'default',
                'type' => 'static_content',
                'name' => 'SOXNSOX Popular Search Tags',
                'sort_order' => 11,
                'status' => 1,
                'channel_id' => 1,
                'options' => json_encode([
                    'css' => '',
                    'html' => '<div class="mt-3.5 pt-3 border-t border-soxnsox-border/60 flex items-center gap-1.5 flex-wrap text-[11px] text-[#6b7280]">
    <span class="font-bold mr-1 text-[#133b63]">Popular Searches:</span>
    <a href="/search?query=Diabetic" class="px-2.5 py-1 rounded-full bg-[#e6f8f7] text-[#208a86] hover:bg-[#2ca7a3] hover:text-white transition-colors">Diabetic Socks</a>
    <a href="/search?query=Plantar" class="px-2.5 py-1 rounded-full bg-[#fef5ea] text-[#d67f1f] hover:bg-[#f29a38] hover:text-white transition-colors">Arch Support</a>
    <a href="/search?query=Ankle" class="px-2.5 py-1 rounded-full bg-[#e9f2fa] text-[#1d5b8f] hover:bg-[#1d5b8f] hover:text-white transition-colors">Bamboo Ankle</a>
    <a href="/search?query=Formal" class="px-2.5 py-1 rounded-full bg-[#f5f7fa] hover:bg-[#133b63] hover:text-white transition-colors">Formal Office</a>
    <a href="/search?query=Anti-Slip" class="px-2.5 py-1 rounded-full bg-[#e6f8f7] text-[#208a86] hover:bg-[#2ca7a3] hover:text-white transition-colors">Anti-Slip Grip</a>
    <a href="/search?query=Pack" class="px-2.5 py-1 rounded-full bg-[#fef5ea] text-[#d67f1f] hover:bg-[#f29a38] hover:text-white transition-colors">Pack of 6</a>
</div>',
                ]),
            ],
            [
                'id' => 7,
                'theme_code' => 'default',
                'type' => 'footer_links',
                'name' => 'Footer Links',
                'sort_order' => 11,
                'status' => 1,
                'channel_id' => 1,
                'options' => json_encode([
                    'column_1' => [
                        ['url' => '/medical-socks', 'title' => 'Medical & Diabetic Socks', 'sort_order' => 1],
                        ['url' => '/men', 'title' => "Men's Bamboo Socks", 'sort_order' => 2],
                        ['url' => '/women', 'title' => "Women's Active & Gym", 'sort_order' => 3],
                        ['url' => '/children', 'title' => 'Kids & Baby Socks', 'sort_order' => 4],
                        ['url' => '/products', 'title' => 'All Sock Multi-Packs', 'sort_order' => 5],
                    ],
                    'column_2' => [
                        ['url' => '/#why-bamboo', 'title' => 'The Bamboo Science', 'sort_order' => 1],
                        ['url' => '/#medical-features', 'title' => 'Diabetic Foot Health', 'sort_order' => 2],
                        ['url' => '/page/about-us', 'title' => 'About SOX N SOX', 'sort_order' => 3],
                        ['url' => '/contact-us', 'title' => 'Contact Support', 'sort_order' => 4],
                        ['url' => '/page/quality', 'title' => 'Quality Standards', 'sort_order' => 5],
                    ],
                    'column_3' => [
                        ['url' => '/page/privacy-policy', 'title' => 'Privacy Policy', 'sort_order' => 1],
                        ['url' => '/page/terms-conditions', 'title' => 'Terms of Sale', 'sort_order' => 2],
                        ['url' => '/page/shipping-policy', 'title' => 'Shipping & Delivery', 'sort_order' => 3],
                        ['url' => '/page/return-policy', 'title' => '7-Day Easy Exchange', 'sort_order' => 4],
                        ['url' => '/sitemap.xml', 'title' => 'XML Sitemap', 'sort_order' => 5],
                    ],
                    'social_links' => [
                        'twitter' => 'https://twitter.com/soxnsox',
                        'youtube' => 'https://youtube.com/@soxnsox',
                        'facebook' => 'https://facebook.com/soxnsox',
                        'linkedin' => 'https://linkedin.com/company/soxnsox',
                        'instagram' => 'https://instagram.com/soxnsox',
                    ],
                ]),
            ],
            [
                'id' => 8,
                'theme_code' => 'default',
                'type' => 'services_content',
                'name' => 'Services Content',
                'sort_order' => 12,
                'status' => 1,
                'channel_id' => 1,
                'options' => json_encode([
                    'services' => [
                        [
                            'title' => '100% Pure Bamboo',
                            'description' => 'Naturally hypoallergenic with zero chemical bleaching or irritants',
                            'service_icon' => 'fa-solid fa-leaf',
                        ],
                        [
                            'title' => 'Bamboo Kun Odour Defense',
                            'description' => 'Naturally eliminates 99.8% of bacteria for 24-hour freshness',
                            'service_icon' => 'fa-solid fa-shield-halved',
                        ],
                        [
                            'title' => 'Free India Shipping',
                            'description' => 'Swift nationwide dispatch & free delivery on orders above ₹499',
                            'service_icon' => 'fa-solid fa-truck-fast',
                        ],
                        [
                            'title' => 'Doctor-Approved Diabetic Fit',
                            'description' => 'Non-binding cuffs and seamless toes to protect blood circulation',
                            'service_icon' => 'fa-solid fa-heart-pulse',
                        ],
                    ],
                ]),
            ],
        ];

        foreach ($customizations as $item) {
            $options = $item['options'];
            unset($item['options']);

            DB::table('theme_customizations')->updateOrInsert(
                ['id' => $item['id']],
                array_merge($item, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );

            DB::table('theme_customization_translations')->updateOrInsert(
                [
                    'theme_customization_id' => $item['id'],
                    'locale' => 'en',
                ],
                [
                    'options' => $options,
                ]
            );
        }

        $this->command->info('SOXNSOX Theme Customizations updated successfully.');
    }
}
