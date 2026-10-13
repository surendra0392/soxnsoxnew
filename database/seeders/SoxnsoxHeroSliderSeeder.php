<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\Theme\Models\HeroLayer;
use Webkul\Theme\Models\HeroSlide;
use Webkul\Theme\Models\HeroSlider;

class SoxnsoxHeroSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            // Find or create the primary SOXNSOX Homepage Hero Slider
            $slider = HeroSlider::updateOrCreate(
                ['code' => 'soxnsox-homepage-hero'],
                [
                    'name' => 'SOXNSOX Homepage Hero',
                    'status' => 1,
                    'placement' => 'homepage',
                    'settings' => [
                        'autoplay' => true,
                        'loop' => true,
                        'duration' => 6000,
                    ],
                ]
            );

            // Define 3 Production Slides with Complete Editorial Hierarchy for SOX N SOX
            $slidesData = [
                [
                    'name' => 'Everyday Bamboo Comfort',
                    'sort_order' => 0,
                    'media_type' => 'image',
                    'desktop_media' => 'images/hero-slide-1.webp',
                    'mobile_media' => 'images/hero-slide-1.webp',
                    'duration' => 6000,
                    'status' => 1,
                    'settings' => [
                        'short_title' => 'Everyday Comfort',
                        'eyebrow' => 'PREMIUM EVERYDAY SOCKS',
                        'title_main' => 'Comfort, Style &',
                        'title_highlight' => 'Support For Every Step',
                        'description' => 'Premium socks designed for everyday comfort, movement, and modern lifestyles — for Men, Women & Children.',
                        'primary_btn_text' => 'SHOP PREMIUM SOCKS',
                        'primary_btn_url' => '/products',
                        'secondary_btn_text' => 'EXPLORE COLLECTIONS',
                        'secondary_btn_url' => '/products',
                        'badges' => [
                            ['icon' => 'fa-solid fa-heart-pulse', 'label1' => 'Breathable', 'label2' => 'Comfort'],
                            ['icon' => 'fa-solid fa-shield-halved', 'label1' => 'Everyday', 'label2' => 'Durability'],
                            ['icon' => 'fa-solid fa-check', 'label1' => 'Soft', 'label2' => 'Support'],
                            ['icon' => 'fa-solid fa-wind', 'label1' => 'Modern', 'label2' => 'Fit'],
                        ],
                    ],
                    'layers' => [
                        [
                            'type' => 'text',
                            'name' => 'Eyebrow',
                            'sort_order' => 0,
                            'content' => 'PREMIUM EVERYDAY SOCKS',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                        [
                            'type' => 'heading',
                            'name' => 'Headline',
                            'sort_order' => 1,
                            'content' => 'Comfort, Style & Support For Every Step',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                        [
                            'type' => 'text',
                            'name' => 'Description',
                            'sort_order' => 2,
                            'content' => 'Premium socks designed for everyday comfort, movement, and modern lifestyles — for Men, Women & Children.',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                    ],
                ],
                [
                    'name' => 'Diabetic & Medical Care',
                    'sort_order' => 1,
                    'media_type' => 'image',
                    'desktop_media' => 'images/hero-slide-2.webp',
                    'mobile_media' => 'images/hero-slide-2.webp',
                    'duration' => 6000,
                    'status' => 1,
                    'settings' => [
                        'short_title' => 'Diabetic Care',
                        'eyebrow' => 'CLINICALLY DESIGNED COMFORT',
                        'title_main' => 'Diabetic & Compression Footwear',
                        'title_highlight' => 'For Sensitive Feet',
                        'description' => 'Non-binding loose-top cuffs that protect blood circulation, hand-linked seamless toes, and cushioned sole relief.',
                        'primary_btn_text' => 'SHOP DIABETIC SOCKS',
                        'primary_btn_url' => '/medical-socks',
                        'secondary_btn_text' => 'VIEW MEDICAL RANGE',
                        'secondary_btn_url' => '/medical-socks',
                        'badges' => [
                            ['icon' => 'fa-solid fa-heart-circle-check', 'label1' => 'Circulation', 'label2' => 'Care'],
                            ['icon' => 'fa-solid fa-feather', 'label1' => 'Non-Binding', 'label2' => 'Tops'],
                            ['icon' => 'fa-solid fa-shield-halved', 'label1' => 'Seamless', 'label2' => 'Toe'],
                            ['icon' => 'fa-solid fa-stethoscope', 'label1' => 'Doctor', 'label2' => 'Approved'],
                        ],
                    ],
                    'layers' => [
                        [
                            'type' => 'text',
                            'name' => 'Eyebrow',
                            'sort_order' => 0,
                            'content' => 'CLINICALLY DESIGNED COMFORT',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                        [
                            'type' => 'heading',
                            'name' => 'Headline',
                            'sort_order' => 1,
                            'content' => 'Diabetic & Compression Footwear For Sensitive Feet',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                        [
                            'type' => 'text',
                            'name' => 'Description',
                            'sort_order' => 2,
                            'content' => 'Non-binding loose-top cuffs that protect blood circulation, hand-linked seamless toes, and cushioned sole relief.',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                    ],
                ],
                [
                    'name' => 'Athletic & Everyday Active',
                    'sort_order' => 2,
                    'media_type' => 'image',
                    'desktop_media' => 'images/hero-slide-3.webp',
                    'mobile_media' => 'images/hero-slide-3.webp',
                    'duration' => 6000,
                    'status' => 1,
                    'settings' => [
                        'short_title' => 'Athletic Grip',
                        'eyebrow' => 'ENGINEERED PERFORMANCE',
                        'title_main' => 'Targeted Arch Support & Anti-Slip Grip',
                        'title_highlight' => 'For Active Life',
                        'description' => 'High-density knit with dynamic mid-foot compression and moisture-wicking fibers for training, work, and everyday movement.',
                        'primary_btn_text' => 'EXPLORE ACTIVEWEAR',
                        'primary_btn_url' => '/products',
                        'secondary_btn_text' => 'SHOP ALL STYLES',
                        'secondary_btn_url' => '/products',
                        'badges' => [
                            ['icon' => 'fa-solid fa-shoe-prints', 'label1' => 'Anti-Slip', 'label2' => 'Traction'],
                            ['icon' => 'fa-solid fa-bolt', 'label1' => 'Dynamic Arch', 'label2' => 'Band'],
                            ['icon' => 'fa-solid fa-droplet-slash', 'label1' => 'Rapid-Dry', 'label2' => 'Mesh'],
                            ['icon' => 'fa-solid fa-shield', 'label1' => 'Reinforced', 'label2' => 'Heel'],
                        ],
                    ],
                    'layers' => [
                        [
                            'type' => 'text',
                            'name' => 'Eyebrow',
                            'sort_order' => 0,
                            'content' => 'ENGINEERED PERFORMANCE',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                        [
                            'type' => 'heading',
                            'name' => 'Headline',
                            'sort_order' => 1,
                            'content' => 'Targeted Arch Support & Anti-Slip Grip For Active Life',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                        [
                            'type' => 'text',
                            'name' => 'Description',
                            'sort_order' => 2,
                            'content' => 'High-density knit with dynamic mid-foot compression and moisture-wicking fibers for training, work, and everyday movement.',
                            'desktop_settings' => ['x' => '0%', 'y' => '0%', 'width' => 'auto'],
                            'settings' => ['classes' => ''],
                        ],
                    ],
                ],
            ];

            // Clean existing slides and re-seed cleanly
            HeroSlide::where('hero_slider_id', $slider->id)->delete();

            foreach ($slidesData as $slideInfo) {
                $layersData = $slideInfo['layers'];
                unset($slideInfo['layers']);

                $slide = HeroSlide::create(array_merge($slideInfo, [
                    'hero_slider_id' => $slider->id,
                ]));

                foreach ($layersData as $layerInfo) {
                    HeroLayer::create(array_merge($layerInfo, [
                        'hero_slide_id' => $slide->id,
                    ]));
                }
            }
        });

        $this->command?->info('SOXNSOX Hero Slider seeded successfully with clean slides!');
    }
}
