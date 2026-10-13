<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\CMS\Models\Page;

class SoxnsoxMenuSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure CMS Pages are correct
        $aboutPage = Page::whereHas('translations', function ($q) {
            $q->where('url_key', 'about-us');
        })->first();

        if ($aboutPage) {
            DB::table('cms_page_translations')->where('cms_page_id', $aboutPage->id)->update([
                'page_title' => 'About Us',
            ]);
        }

        $qualityPage = Page::whereHas('translations', function ($q) {
            $q->where('url_key', 'quality');
        })->first();

        if ($qualityPage) {
            DB::table('cms_page_translations')->where('cms_page_id', $qualityPage->id)->update([
                'page_title' => 'Quality',
            ]);
        }

        // 2. Build the Custom Menu Items array matching SOXNSOX Header Structure
        $menuItems = [
            [
                'type' => 'custom',
                'id' => 'custom_shop_products',
                'title' => 'Products',
                'url' => url('/products'),
            ],
            [
                'type' => 'cms',
                'id' => 'about-us',
                'title' => 'About Us',
                'url' => url('/page/about-us'),
            ],
            [
                'type' => 'cms',
                'id' => 'why-choose-us',
                'title' => 'Why Choose Us',
                'url' => url('/page/why-choose-us'),
            ],
            [
                'type' => 'cms',
                'id' => 'how-it-works',
                'title' => 'How It Works',
                'url' => url('/page/how-it-works'),
            ],
            [
                'type' => 'custom',
                'id' => 'custom_contact',
                'title' => 'Contact Us',
                'url' => url('/contact-us'),
            ],
        ];

        // 3. Set the Core Config for Custom Menu (both channel-specific and global)
        $configKey = 'general.design.categories.custom_menu_items';
        $viewConfigKey = 'general.design.categories.category_view';

        foreach (['default', null] as $channelCode) {
            DB::table('core_config')->updateOrInsert(
                [
                    'code' => $configKey,
                    'channel_code' => $channelCode,
                    'locale_code' => null,
                ],
                [
                    'value' => json_encode($menuItems),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::table('core_config')->updateOrInsert(
                [
                    'code' => $viewConfigKey,
                    'channel_code' => $channelCode,
                    'locale_code' => null,
                ],
                [
                    'value' => 'custom',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
