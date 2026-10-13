<?php

namespace Webkul\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Webkul\Blog\Models\Blog;
use Webkul\Product\Models\Product;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing blogs
        Schema::disableForeignKeyConstraints();
        DB::table('blog_products')->truncate();
        DB::table('blog_translations')->truncate();
        DB::table('blogs')->truncate();
        Schema::enableForeignKeyConstraints();

        // Ensure blog media assets are copied to storage
        $blogSourceDir = base_path('packages/Webkul/Installer/src/Resources/assets/images/seeders/blogs');
        $storageBlogDir = storage_path('app/public/blogs');
        $pubBlogDir = public_path('storage/blogs');

        if (! file_exists($storageBlogDir)) {
            mkdir($storageBlogDir, 0777, true);
        }
        if (! file_exists($pubBlogDir)) {
            mkdir($pubBlogDir, 0777, true);
        }

        if (file_exists($blogSourceDir)) {
            $files = glob($blogSourceDir.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $baseName = basename($file);
                    copy($file, $storageBlogDir.'/'.$baseName);
                    copy($file, $pubBlogDir.'/'.$baseName);
                }
            }
        }

        $blogsData = [
            [
                'featured_image' => 'blogs/science-behind-bamboo-socks.webp',
                'author_name' => 'SOX N SOX Research Lab',
                'author_title' => 'Textile & Fiber Engineering',
                'read_time' => 5,
                'status' => 1,
                'published_at' => now()->subDays(10),
                'translations' => [
                    'name' => 'The Science Behind Bamboo Socks: Why Your Feet Stay Cooler, Drier, and Odour-Free',
                    'url_key' => 'science-behind-bamboo-socks',
                    'category' => 'Bamboo Science',
                    'short_description' => 'Discover how microscopic cross-sections of natural bamboo fibers deliver 3-4x superior moisture-wicking, natural antibacterial odour defense, and all-day thermal regulation compared to conventional cotton.',
                    'content' => '
<h2>Why Cotton Fails Your Feet</h2>
<p>For decades, conventional cotton has been the default choice for socks. However, cotton fibers have a solid cylindrical structure that acts like a sponge—absorbing sweat and trapping it against your skin. In warm climates or during long hours at the office, this damp environment breeds bacteria, accelerates friction blisters, and causes persistent foot odor.</p>

<div class="my-6 p-6 rounded-2xl bg-teal-50/70 border border-teal-200/80 text-teal-900">
    <h4 class="font-bold text-teal-900 text-base mb-2">Key Takeaway</h4>
    <p class="text-sm leading-relaxed mb-0">Natural bamboo viscose features micro-gaps and micro-holes in its fiber cross-section. This capillary effect draws moisture away from your skin 4 times faster than standard combed cotton, keeping your feet dry even during 12-hour workdays.</p>
</div>

<h2>The Natural Antibacterial Bio-Agent: "Bamboo Kun"</h2>
<p>Bamboo plants in the wild rarely succumb to fungal infestations or pest damage. This natural resistance is powered by a unique bio-agent called <em>Bamboo Kun</em>. When processed into ultra-fine textile filaments, bamboo retains its inherent bacteriostatic qualities:</p>
<ul class="list-disc pl-6 space-y-2 my-4">
    <li><strong>Inhibits 99.8% of Odour-Causing Bacteria:</strong> Laboratory tests demonstrate that bacteria fails to proliferate on bamboo fabrics compared to untreated synthetic polyesters or damp cotton.</li>
    <li><strong>Hypoallergenic by Nature:</strong> Free of harsh agricultural chemical residues and pesticides, bamboo fibers are non-irritating for sensitive skin and eczema sufferers.</li>
    <li><strong>Micro-Ventilation:</strong> The micro-structure allows continuous air exchange, maintaining an optimal microclimate inside formal shoes, boots, and sneakers.</li>
</ul>

<h2>Thermal Regulation: Cool in Summer, Warm in Winter</h2>
<p>Bamboo is naturally thermoregulating. In scorching summer temperatures, it dissipates body heat rapidly through its ventilated matrix. During cooler monsoon or winter mornings, the microscopic air pockets trap a thin boundary layer of warmth, ensuring effortless year-round comfort.</p>

<h2>Cashmere-Grade Softness Without the Premium Maintenance</h2>
<p>Under a microscope, bamboo viscose filaments are rounded and silky-smooth with zero rough spurs. This produces a texture comparable to silk or fine cashmere that glides across your skin without friction or roughness, wash after wash.</p>
',
                    'meta_title' => 'The Science Behind Bamboo Socks | SOX N SOX',
                    'meta_description' => 'Explore how bamboo fibers provide 4x better moisture wicking, natural antibacterial defense, and thermal comfort for all-day freshness.',
                    'meta_keywords' => 'bamboo socks science, antibacterial socks, moisture wicking, foot odour prevention, soxnsox',
                ],
            ],
            [
                'featured_image' => 'blogs/guide-to-diabetic-friendly-socks.webp',
                'author_name' => 'Dr. Ananya Sharma',
                'author_title' => 'Podiatry & Foot Wellness Consultant',
                'read_time' => 6,
                'status' => 1,
                'published_at' => now()->subDays(6),
                'translations' => [
                    'name' => 'Living With Diabetes: The Essential Podiatrist Guide to Diabetic Friendly Socks',
                    'url_key' => 'guide-to-diabetic-friendly-socks',
                    'category' => 'Diabetic Care',
                    'short_description' => 'Learn why individuals with diabetes require specialized non-binding socks with seamless hand-linked toes, gentle circulation support, and antimicrobial bamboo protection to prevent pressure sores.',
                    'content' => '
<h2>The Hidden Risk in Everyday Socks</h2>
<p>For individuals managing diabetes, daily foot care is not merely a matter of comfort—it is a critical preventive medical priority. Diabetes often leads to two major complications in the lower extremities: <strong>peripheral neuropathy</strong> (reduced nerve sensitivity) and <strong>peripheral arterial disease</strong> (impaired blood circulation).</p>

<p>When sensation is diminished, minor irritations like a bulky toe seam, a rough elastic band, or trapped moisture can cause friction sores or fungal infections without the wearer feeling any pain. Left unaddressed, these minor sores can escalate rapidly.</p>

<div class="my-6 p-6 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-amber-900">
    <h4 class="font-bold text-amber-900 text-base mb-2">Why Standard Socks Pose a Risk</h4>
    <p class="text-sm leading-relaxed mb-0">Conventional socks use tight elastic top cuffs designed to grip the leg tightly. In diabetic individuals, this elastic tourniquet effect restricts already compromised micro-vascular blood return, leading to swelling (edema), cold extremities, and skin breakdown.</p>
</div>

<h2>What Makes a True Diabetic Sock?</h2>
<p>At SOX N SOX, our medical-grade diabetic socks are specifically engineered around podiatric recommendations:</p>
<ol class="list-decimal pl-6 space-y-3 my-4">
    <li><strong>Non-Binding Honeycomb Top:</strong> A specially knitted wide-rib cuff that gently rests against the calf without constricting venous return or leaving deep red indentations on the skin.</li>
    <li><strong>Hand-Linked Seamless Toes:</strong> Standard machine-sewn socks leave a thick raised seam that presses directly against the tops of toes. Our seamless hand-linking eliminates this ridge completely, preventing friction blisters.</li>
    <li><strong>Antimicrobial Bamboo Shield:</strong> Because diabetic feet are more vulnerable to fungal issues such as Athlete\'s foot, the bacteriostatic properties of bamboo provide a natural defensive barrier against microbial overgrowth.</li>
    <li><strong>Terry-Cushioned Sole:</strong> An ultra-soft terry-loop padded bottom absorbs vertical ground impact, distributing weight evenly across the metatarsals and heel to reduce pressure points.</li>
</ol>

<h2>5 Daily Podiatric Foot Habits for Diabetics</h2>
<ul class="list-disc pl-6 space-y-2 my-4">
    <li>Inspect your feet daily in good lighting for any redness, calluses, or small abrasions.</li>
    <li>Never walk barefoot—even indoors on smooth marble or tile floors.</li>
    <li>Wash feet daily in lukewarm water; pat dry thoroughly between the toes.</li>
    <li>Change your bamboo socks immediately if your feet become wet from rain or exercise.</li>
    <li>Select properly fitted shoes with a wide toe box that accommodates cushioned socks without pinching.</li>
</ul>
',
                    'meta_title' => 'Diabetic Friendly Socks Guide | Podiatrist Advice | SOX N SOX',
                    'meta_description' => 'Understand how non-binding cuffs, seamless toes, and antimicrobial bamboo fibers protect diabetic feet from circulation issues and pressure sores.',
                    'meta_keywords' => 'diabetic socks, non-binding socks, podiatrist foot care, diabetic neuropathy socks, soxnsox medical',
                ],
            ],
            [
                'featured_image' => 'blogs/blister-prevention-seamless-socks.webp',
                'author_name' => 'Vikram Patel',
                'author_title' => 'Marathon Runner & Footwear Ergonomics Lead',
                'read_time' => 4,
                'status' => 1,
                'published_at' => now()->subDays(3),
                'translations' => [
                    'name' => 'Blister Prevention 101: How Hand-Linked Seamless Toes Protect Active Feet',
                    'url_key' => 'blister-prevention-seamless-socks',
                    'category' => 'Foot Health',
                    'short_description' => 'Friction, moisture, and bulky machine-sewn ridges are the #1 cause of foot blisters. Discover how true hand-linked toe seams eliminate pressure points during workouts, running, and daily commutes.',
                    'content' => '
<h2>The Physics of a Blister</h2>
<p>Every active runner, gym enthusiast, and daily walker has experienced the painful sting of a foot blister. But what actually causes it? A blister is the result of mechanical <strong>shear stress</strong> combined with excess moisture and heat:</p>
<ul class="list-disc pl-6 space-y-2 my-4">
    <li><strong>Friction:</strong> Repeated micro-rubbing between sock fibers and the upper layers of your skin creates microscopic tears.</li>
    <li><strong>Moisture:</strong> Damp skin has a significantly higher coefficient of friction than dry skin, making it substantially weaker and prone to tearing.</li>
    <li><strong>Pressure Ridges:</strong> Any raised surface—such as the standard bulky seam across your toe line—concentrates friction onto a single point.</li>
</ul>

<div class="my-6 p-6 rounded-2xl bg-teal-50/70 border border-teal-200/80 text-teal-900">
    <h4 class="font-bold text-teal-900 text-base mb-2">Machine Sewing vs Hand-Linked Seams</h4>
    <p class="text-sm leading-relaxed mb-0">Conventional mass-market sock machines close the toe by sewing the top and bottom fabric together with a thick overlock thread. In contrast, <em>Hand-Linked Toe construction</em> links each individual stitch together by hand, resulting in an entirely flat, ridge-free seam that is virtually undetectable to your toes.</p>
</div>

<h2>Zero-Chafe Performance with Bamboo Viscose</h2>
<p>When combined with hand-linked toes, bamboo fiber elevates blister prevention to a whole new tier. Because bamboo threads are rounder and smoother than coarse synthetic acrylics or rough cotton, there are no abrasive fiber ends to abrade sensitive skin during intensive foot strikes.</p>

<h2>3 Pro Tips for Long-Distance Comfort</h2>
<ol class="list-decimal pl-6 space-y-2 my-4">
    <li><strong>Ensure Correct Sock Fit:</strong> A loose sock bunches up inside the shoe, creating new friction folds. A tight sock stretches the fabric thin and accelerates wear. SOX N SOX socks feature an elasticated arch band that hugs your instep firmly.</li>
    <li><strong>Avoid 100% Synthetic Socks:</strong> Polyester and nylon retain heat and slide against damp skin, raising skin surface temperature and promoting blister formation.</li>
    <li><strong>Rotate Pairs:</strong> Allow your footwear and socks adequate time to breathe between long runs or workout sessions.</li>
</ol>
',
                    'meta_title' => 'Blister Prevention: Seamless Hand-Linked Bamboo Socks | SOX N SOX',
                    'meta_description' => 'Learn how hand-linked seamless toes and moisture-wicking bamboo fibers eliminate friction blisters for runners, walkers, and active lifestyles.',
                    'meta_keywords' => 'blister prevention socks, seamless toe socks, hand linked socks, running socks, anti blister',
                ],
            ],
            [
                'featured_image' => 'blogs/how-to-wash-bamboo-socks.webp',
                'author_name' => 'SOX N SOX Care Team',
                'author_title' => 'Product Care Specialists',
                'read_time' => 3,
                'status' => 1,
                'published_at' => now()->subDays(1),
                'translations' => [
                    'name' => 'How to Wash and Care for Your Bamboo Socks: The Ultimate Longevity Guide',
                    'url_key' => 'how-to-wash-bamboo-socks',
                    'category' => 'Sock Care',
                    'short_description' => 'Keep your bamboo socks silky-soft, vibrant, and resilient for years. Our simple step-by-step washing, drying, and storage guide protects the delicate natural cellulose fibers wash after wash.',
                    'content' => '
<h2>Caring for Natural Bamboo Cellulose</h2>
<p>Bamboo socks are renowned for their heavenly cloud-like softness and durable elasticity. However, because bamboo is a natural cellulose fiber, following a few simple laundry best practices will ensure your favorite pairs retain their shape, softness, and vibrant color for dozens of washes.</p>

<h2>Step 1: Wash Inside-Out in Cold or Warm Water</h2>
<p>Before placing your socks in the washing machine, turn them inside out. This serves two key purposes:</p>
<ul class="list-disc pl-6 space-y-2 my-4">
    <li>It washes the interior surface directly where sweat and dead skin cells accumulate.</li>
    <li>It protects the exterior finish from friction against zippers or rough denim in the wash drum.</li>
    <li>Always choose a <strong>cold or gentle 30&deg;C cycle</strong>. Excessive boiling water can weaken the natural elastic elastane core.</li>
</ul>

<div class="my-6 p-6 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-amber-900">
    <h4 class="font-bold text-amber-900 text-base mb-2">Skip the Fabric Softener!</h4>
    <p class="text-sm leading-relaxed mb-0">Fabric softeners leave a microscopic chemical waxy film over fabrics. This coating clogs bamboo\'s natural micro-pores and inhibits its moisture-wicking and breathability. Bamboo is already naturally ultra-soft—it never needs chemical softeners!</p>
</div>

<h2>Step 2: Avoid Chlorine Bleach</h2>
<p>Chlorine bleach is extremely harsh on plant-based cellulose fibers and will break down the delicate structure of bamboo threads, leading to premature thinning and holes. For white socks, opt for gentle oxygen-based brighteners or natural baking soda instead.</p>

<h2>Step 3: Gentle Drying</h2>
<p>Air-drying is the gentlest method for your bamboo socks. Simply line-dry in the shade. If you must use a tumble dryer, select a <strong>low heat / delicate setting</strong> to avoid thermal shock to the elastane fibers.</p>

<h2>Step 4: Storage Tip</h2>
<p>When storing your socks in your drawer, fold them flat or roll them gently together. Avoid rolling the top cuff inside-out into a tight "ball"—this over-stretches the top elastic band and degrades the non-binding cuff over time.</p>
',
                    'meta_title' => 'How to Wash & Care for Bamboo Socks | SOX N SOX Care Guide',
                    'meta_description' => 'Easy step-by-step instructions on washing, drying, and maintaining your bamboo socks for maximum softness, hygiene, and years of comfort.',
                    'meta_keywords' => 'how to wash bamboo socks, bamboo sock care, laundry tips, soft socks guide, soxnsox care',
                ],
            ],
        ];

        // Fetch parent products only to associate (never child variants)
        $allProducts = Product::whereNull('parent_id')->get();

        foreach ($blogsData as $index => $bData) {
            $trans = $bData['translations'];
            unset($bData['translations']);

            $locale = app()->getLocale();
            $blogPayload = array_merge($bData, [
                $locale => $trans,
            ]);

            $blog = Blog::create($blogPayload);

            // Associate relevant products for cross-sell
            if ($allProducts->isNotEmpty()) {
                // Link 2-3 products per blog post
                $productIds = $allProducts->slice($index * 2, 2)->pluck('id')->toArray();
                if (! empty($productIds)) {
                    $blog->products()->sync($productIds);
                }
            }
        }
    }
}
