<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoxnsoxSEOSeeder extends Seeder
{
    /**
     * Seed comprehensive, high-ranking SEO metadata across Channels, Categories, Products, and CMS.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Channel 1 SEO Configuration (Home Page)
        $homeSeoData = [
            'meta_title' => 'SOX N SOX — 100% Bamboo Socks & Diabetic Socks Online India',
            'meta_description' => 'Shop SOX N SOX: India’s #1 bamboo socks and doctor-approved diabetic socks. 100% seamless hand-linked toe blister protection, non-binding cuffs, and 24h odour defense. Free shipping over ₹499.',
            'meta_keywords' => 'bamboo socks, diabetic socks india, seamless toe socks, bamboo socks for men, gym socks for women, odor free bamboo socks, medical socks online, anti blister socks, plantar fasciitis socks, compression socks, soxnsox',
        ];

        DB::table('channels')->where('id', 1)->update([
            'home_seo' => json_encode($homeSeoData),
            'updated_at' => $now,
        ]);

        DB::table('channel_translations')->where('channel_id', 1)->update([
            'home_seo' => json_encode($homeSeoData),
            'updated_at' => $now,
        ]);

        // 2. Enable Rich Snippets in core_config table
        $richSnippetConfigs = [
            'catalog.rich_snippets.products.enable' => '1',
            'catalog.rich_snippets.products.show_sku' => '1',
            'catalog.rich_snippets.products.show_weight' => '1',
            'catalog.rich_snippets.products.show_categories' => '1',
            'catalog.rich_snippets.products.show_images' => '1',
            'catalog.rich_snippets.products.show_reviews' => '1',
            'catalog.rich_snippets.products.show_ratings' => '1',
            'catalog.rich_snippets.products.show_offers' => '1',
            'catalog.rich_snippets.categories.enable' => '1',
            'catalog.rich_snippets.categories.show_search_input_field' => '1',
            'general.sitemap.settings.enabled' => '1',
            'general.sitemap.file_limits.max_url_per_file' => '50000',
        ];

        foreach ($richSnippetConfigs as $code => $value) {
            DB::table('core_config')->updateOrInsert(
                ['code' => $code, 'channel_code' => null, 'locale_code' => null],
                ['value' => $value, 'created_at' => $now, 'updated_at' => $now]
            );
            DB::table('core_config')->updateOrInsert(
                ['code' => $code, 'channel_code' => 'default', 'locale_code' => null],
                ['value' => $value, 'created_at' => $now, 'updated_at' => $now]
            );
        }

        // 3. Category High-Rank SEO Metadata (Main and Subcategories)
        $categoriesSeo = [
            'medical-socks' => [
                'name' => 'Medical Socks',
                'meta_title' => 'Diabetic & Medical Bamboo Socks India | Doctor Approved | SOX N SOX',
                'meta_description' => 'Buy doctor-recommended diabetic bamboo socks online in India. Engineered with non-binding honeycomb cuffs, seamless hand-linked toes, and antimicrobial moisture defense.',
                'meta_keywords' => 'diabetic socks india, medical socks, non-binding socks, seamless diabetic socks, diabetic foot care, doctor approved socks, swollen feet socks',
            ],
            'men' => [
                'name' => 'Men\'s Bamboo Socks',
                'meta_title' => 'Men\'s Bamboo Socks | Formal Office & Ankle Sports Socks | SOX N SOX',
                'meta_description' => 'Buy premium bamboo socks for men online. Ultra-soft, breathable, and naturally odour-free formal crew and athletic ankle socks. Multi-packs with free express delivery across India.',
                'meta_keywords' => 'bamboo socks men, formal socks men, ankle socks men, odour free socks, breathable socks men, mens cotton alternative socks, soxnsox',
            ],
            'women' => [
                'name' => 'Women\'s Bamboo Socks',
                'meta_title' => 'Women\'s Bamboo Socks | Gym, Activewear & Daily Comfort | SOX N SOX',
                'meta_description' => 'Discover cloud-soft bamboo socks for women. Designed for workouts, yoga, running, and all-day comfort with arch support, cushioning, and blister-free seamless hand-linked toes.',
                'meta_keywords' => 'women bamboo socks, gym socks women, activewear socks, running socks women, soft ankle socks, ladies socks india',
            ],
            'children' => [
                'name' => 'Kids & Toddler Socks',
                'meta_title' => 'Kids & Toddler Bamboo Socks | Hypoallergenic, Non-Slip Grip | SOX N SOX',
                'meta_description' => 'Gentle, skin-friendly bamboo socks for kids and infants. 100% natural antibacterial protection, non-slip silicone grips, and seamless toe comfort for sensitive little feet.',
                'meta_keywords' => 'kids bamboo socks, baby socks, toddler anti slip socks, hypoallergenic socks kids, natural soft socks, children socks india',
            ],
            'performance' => [
                'name' => 'Athletic & Performance Socks',
                'meta_title' => 'Athletic & Performance Bamboo Sports Socks | SOX N SOX',
                'meta_description' => 'Engineered sports socks with dynamic mid-foot arch support, breathable ventilation mesh, and reinforced heel/toe for workouts, running, and high-intensity training.',
                'meta_keywords' => 'sports socks, athletic socks, running socks, arch support socks, moisture wicking sports socks, workout socks india',
            ],
            'compression-socks' => [
                'name' => 'Everyday Compression Socks',
                'meta_title' => 'Everyday Compression Bamboo Socks | Circulation Support | SOX N SOX',
                'meta_description' => 'Graduated compression bamboo socks designed to improve lower-leg blood circulation, relieve swelling, and reduce travel/work fatigue. Ultra-breathable natural bamboo fabric.',
                'meta_keywords' => 'compression socks india, travel compression socks, circulation socks, varicose vein socks, bamboo compression socks, swelling relief',
            ],
            'plantar-fasciitis' => [
                'name' => 'Plantar Fasciitis Support Socks',
                'meta_title' => 'Plantar Fasciitis Arch Support Bamboo Socks | SOX N SOX',
                'meta_description' => 'Targeted plantar fasciitis relief socks. Featuring focused arch compression band, heel shock absorption, and all-day soothing comfort for foot strain and morning heel pain.',
                'meta_keywords' => 'plantar fasciitis socks, arch support socks, heel pain relief socks, foot pain socks india, plantar fasciitis compression',
            ],
            'everyday-comfort' => [
                'name' => 'Everyday Comfort Socks',
                'meta_title' => 'Everyday Comfort Bamboo Crew & Ankle Socks | SOX N SOX',
                'meta_description' => 'Cloud-like everyday softness. Hypoallergenic bamboo fiber keeps your feet 2x softer, cooler, and fresher from morning to night. Multi-packs with free shipping in India.',
                'meta_keywords' => 'everyday bamboo socks, soft socks, casual socks, comfortable ankle socks, daily wear socks',
            ],
        ];

        foreach ($categoriesSeo as $slug => $seo) {
            DB::table('category_translations')->where('slug', $slug)->update([
                'name' => $seo['name'],
                'meta_title' => $seo['meta_title'],
                'meta_description' => $seo['meta_description'],
                'meta_keywords' => $seo['meta_keywords'],
            ]);
        }

        // 4. Products High-Rank SEO Metadata (All 12 Products in product_flat)
        $productsSeo = [
            'all-day-comfort-socks' => [
                'meta_title' => 'All-Day Comfort Bamboo Socks | 24H Freshness | SOX N SOX',
                'meta_description' => 'Experience cloud-like cushioning with SOX N SOX All-Day Comfort Bamboo Socks. Naturally antibacterial, moisture-wicking, and blister-free seamless toe design.',
                'meta_keywords' => 'all day comfort socks, bamboo socks, soft crew socks, daily wear socks, soxnsox',
            ],
            'anti-slip-activity-socks' => [
                'meta_title' => 'Anti-Slip Bamboo Activity Socks | Grip Traction | SOX N SOX',
                'meta_description' => 'SOX N SOX Anti-Slip Activity Socks feature silicone traction grips and premium breathable bamboo fabric for hospital floors, yoga, gym workouts, and home movement.',
                'meta_keywords' => 'anti slip socks, grip socks, yoga socks, hospital socks, activity bamboo socks',
            ],
            'arch-support-plantar-socks' => [
                'meta_title' => 'Arch Support Plantar Fasciitis Bamboo Socks | SOX N SOX',
                'meta_description' => 'Targeted arch compression and heel shock absorption help relieve plantar fasciitis pain and foot fatigue. Ultra-breathable antibacterial bamboo knit.',
                'meta_keywords' => 'arch support socks, plantar fasciitis socks, foot pain relief, compression band socks',
            ],
            'bamboo-ankle-sports-socks' => [
                'meta_title' => 'Bamboo Ankle Sports Socks | Moisture Wicking & Blister-Free | SOX N SOX',
                'meta_description' => 'Lightweight athletic ankle socks crafted from certified bamboo viscose. Dynamic arch band, rapid-dry ventilation mesh, and hand-linked seamless toes.',
                'meta_keywords' => 'bamboo ankle socks, sports socks, running socks, gym ankle socks, blister free socks',
            ],
            'bamboo-formal-office-socks' => [
                'meta_title' => 'Men’s Bamboo Formal Office Socks | Odour-Free Dress Socks | SOX N SOX',
                'meta_description' => 'Elevate your workday with SOX N SOX Bamboo Formal Office Socks. Ultra-fine knit, non-sag ribbed calf, 24-hour odour defense, and elegant executive finish.',
                'meta_keywords' => 'formal office socks, dress socks men, bamboo dress socks, executive socks, odourless socks',
            ],
            'breathable-daily-socks' => [
                'meta_title' => 'Breathable Daily Bamboo Socks | Lightweight Freshness | SOX N SOX',
                'meta_description' => 'Ultra-breathable daily bamboo socks engineered for warm climates. Superior micro-ventilation prevents sweat buildup and keeps feet fresh all day long.',
                'meta_keywords' => 'breathable socks, daily socks, lightweight bamboo socks, summer socks india',
            ],
            'anti-slip-grip-socks' => [
                'meta_title' => 'Diabetic Friendly Bamboo Crew Socks | Doctor Approved | SOX N SOX',
                'meta_description' => 'Medical-grade diabetic friendly bamboo socks with non-binding wide honeycomb top, hand-linked seamless toes, terry cushioned sole, and antimicrobial defense.',
                'meta_keywords' => 'diabetic socks, medical socks, non binding socks, seamless socks diabetic, doctor recommended socks',
            ],
            'everyday-compression-socks' => [
                'meta_title' => 'Everyday Compression Bamboo Socks | Varicose & Travel Relief | SOX N SOX',
                'meta_description' => 'Graduated mild compression socks promote healthy venous blood flow, reduce swelling, and prevent fatigue during travel, desk work, or long standing.',
                'meta_keywords' => 'compression socks, travel socks, leg fatigue relief, circulation socks bamboo',
            ],
            'gym-performance-bamboo-socks' => [
                'meta_title' => 'Gym Performance Bamboo Socks | High-Density Workout Socks | SOX N SOX',
                'meta_description' => 'High-impact workout socks with reinforced heel/toe pads, dynamic arch support band, and rapid moisture wicking for intense training and cardio.',
                'meta_keywords' => 'gym socks, workout socks, athletic bamboo socks, crossfit socks, sports crew socks',
            ],
            'infant-comfort-bamboo-socks-for-babies' => [
                'meta_title' => 'Baby & Infant Bamboo Socks | Ultra Soft & Hypoallergenic | SOX N SOX',
                'meta_description' => 'Protect delicate baby feet with SOX N SOX Infant Comfort Bamboo Socks. Naturally hypoallergenic, chemical-free, seamless toes, and gentle non-pinching cuffs.',
                'meta_keywords' => 'baby bamboo socks, infant socks, newborn soft socks, hypoallergenic baby socks',
            ],
            'yoga-grip-bamboo-socks' => [
                'meta_title' => 'Yoga & Pilates Grip Bamboo Socks | Non-Slip Studio Socks | SOX N SOX',
                'meta_description' => 'High-traction silicone grip socks for yoga, pilates, barre, and studio fitness. Breathable bamboo fabric keeps feet dry and firmly balanced on mats and floors.',
                'meta_keywords' => 'yoga grip socks, pilates socks, non slip studio socks, barre grip socks',
            ],
            'lightweight-everyday-socks' => [
                'meta_title' => 'Lightweight Everyday Bamboo Socks | Cloud Soft Comfort | SOX N SOX',
                'meta_description' => 'Light as air and silky to the touch. SOX N SOX Lightweight Bamboo Socks provide effortless comfort for loafers, sneakers, and casual wear.',
                'meta_keywords' => 'lightweight socks, casual socks, soft bamboo socks, low cut socks india',
            ],
        ];

        foreach ($productsSeo as $urlKey => $pSeo) {
            DB::table('product_flat')->where('url_key', $urlKey)->update([
                'meta_title' => $pSeo['meta_title'],
                'meta_description' => $pSeo['meta_description'],
                'meta_keywords' => $pSeo['meta_keywords'],
            ]);
        }

        // 5. CMS Pages High-Rank SEO Metadata (About Us, Why Choose Us, How It Works, Contact Us, Quality)
        $cmsPagesSeo = [
            'about-us' => [
                'meta_title' => 'About SOX N SOX | India’s Premier Bamboo & Foot Health Brand',
                'meta_description' => 'Discover the story of SOX N SOX: engineering India’s softest, most breathable bamboo socks and doctor-approved diabetic footwear with sustainable fiber technology.',
                'meta_keywords' => 'about soxnsox, bamboo sock brand india, diabetic sock company, sustainable footwear india',
            ],
            'why-choose-us' => [
                'meta_title' => 'Why Choose SOX N SOX | Bamboo vs Cotton Socks Comparison',
                'meta_description' => 'See why bamboo socks beat cotton: 4x moisture wicking, 99.8% natural antibacterial defense, zero-rub seamless toes, and doctor-approved non-binding cuffs.',
                'meta_keywords' => 'why choose soxnsox, bamboo vs cotton socks, benefits of bamboo socks, blister free socks',
            ],
            'how-it-works' => [
                'meta_title' => 'How SOX N SOX Bamboo Socks Are Made | Craftsmanship & Science',
                'meta_description' => 'Explore the craftsmanship behind SOX N SOX: sustainably harvested bamboo cellulose, 200-needle precision circular knitting, and hand-linked seamless toe craftsmanship.',
                'meta_keywords' => 'how bamboo socks are made, sock manufacturing, hand linked seamless toe, 200 needle knit',
            ],
            'quality' => [
                'meta_title' => 'Quality Guarantee & Podiatric Standards | SOX N SOX',
                'meta_description' => 'Our 100% quality guarantee: certified OEKO-TEX bamboo fibers, dermatologically tested hypoallergenic fabrics, and rigorous multi-stage quality inspections.',
                'meta_keywords' => 'soxnsox quality guarantee, certified bamboo socks, hypoallergenic socks',
            ],
            'shipping-policy' => [
                'meta_title' => 'Shipping & Delivery Policy | Free Express Delivery | SOX N SOX',
                'meta_description' => 'Fast, reliable door-to-door delivery across India. Free shipping on all orders above ₹499. Dispatched within 24 hours with live courier tracking.',
                'meta_keywords' => 'soxnsox shipping, delivery timeframe india, free shipping socks',
            ],
            'return-policy' => [
                'meta_title' => '7-Day Easy Return & Replacement Policy | SOX N SOX',
                'meta_description' => 'Hassle-free 7-day returns and exchanges on unworn socks. 100% customer satisfaction guarantee with instant replacement assistance.',
                'meta_keywords' => 'soxnsox returns, replacement policy, return guarantee',
            ],
        ];

        foreach ($cmsPagesSeo as $urlKey => $cSeo) {
            DB::table('cms_page_translations')->where('url_key', $urlKey)->update([
                'meta_title' => $cSeo['meta_title'],
                'meta_description' => $cSeo['meta_description'],
                'meta_keywords' => $cSeo['meta_keywords'],
            ]);
        }
    }
}
