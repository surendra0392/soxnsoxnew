<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Webkul\Category\Models\Category;
use Webkul\Product\Helpers\Indexers\Flat;
use Webkul\Product\Helpers\Indexers\Inventory;
use Webkul\Product\Helpers\Indexers\Price;

class SoxnsoxCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('=== SOXNSOX Configurable Catalog Seeder ===');

        $now = Carbon::now();
        $rootId = 1;
        $channelId = 1;
        $attributeFamilyId = 1;
        $inventorySourceId = 1;

        // --------------------------------------------------------------------
        // 1. Ensure "pack_size" attribute and options exist
        // --------------------------------------------------------------------
        $this->command->info('Setting up pack_size and color attributes...');

        $packSizeAttr = DB::table('attributes')->where('code', 'pack_size')->first();
        if (! $packSizeAttr) {
            $packSizeAttrId = DB::table('attributes')->insertGetId([
                'code' => 'pack_size',
                'admin_name' => 'Pack Size',
                'type' => 'select',
                'swatch_type' => 'text',
                'validation' => null,
                'position' => 28,
                'is_required' => 0,
                'is_unique' => 0,
                'value_per_locale' => 0,
                'value_per_channel' => 0,
                'default_value' => null,
                'is_filterable' => 1,
                'is_configurable' => 1,
                'is_user_defined' => 1,
                'is_visible_on_front' => 1,
                'is_comparable' => 0,
                'enable_wysiwyg' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('attribute_translations')->insert([
                'attribute_id' => $packSizeAttrId,
                'locale' => 'en',
                'name' => 'Pack Size',
            ]);

            // Add pack_size to default attribute group (General)
            $generalGroup = DB::table('attribute_groups')
                ->where('attribute_family_id', $attributeFamilyId)
                ->where('name', 'General')
                ->first();

            if ($generalGroup) {
                DB::table('attribute_group_mappings')->insert([
                    'attribute_group_id' => $generalGroup->id,
                    'attribute_id' => $packSizeAttrId,
                    'position' => 28,
                ]);
            }
        } else {
            $packSizeAttrId = $packSizeAttr->id;
            DB::table('attributes')->where('id', $packSizeAttrId)->update([
                'is_configurable' => 1,
                'is_filterable' => 1,
                'is_visible_on_front' => 1,
                'swatch_type' => 'text',
                'updated_at' => $now,
            ]);
        }

        // Options: Pack of 4, Pack of 6, Pack of 12
        $packOptions = [
            'Pack of 4' => 1,
            'Pack of 6' => 2,
            'Pack of 12' => 3,
        ];
        $packOptionMap = [];
        foreach ($packOptions as $label => $sort) {
            $existingOpt = DB::table('attribute_options')
                ->where('attribute_id', $packSizeAttrId)
                ->where(function ($q) use ($label) {
                    $q->where('admin_name', $label)
                        ->orWhere('admin_name', str_ireplace('of', 'Of', $label));
                })
                ->first();

            if ($existingOpt) {
                $optId = $existingOpt->id;
                DB::table('attribute_options')->where('id', $existingOpt->id)->update([
                    'admin_name' => $label,
                    'swatch_value' => $label,
                    'sort_order' => $sort,
                ]);
            } else {
                $optId = DB::table('attribute_options')->insertGetId([
                    'attribute_id' => $packSizeAttrId,
                    'admin_name' => $label,
                    'sort_order' => $sort,
                    'swatch_value' => $label,
                ]);

                DB::table('attribute_option_translations')->insert([
                    'attribute_option_id' => $optId,
                    'locale' => 'en',
                    'label' => $label,
                ]);
            }

            $packOptionMap[$label] = $optId;
            $packOptionMap[strtoupper($label)] = $optId;
            $packOptionMap[strtolower($label)] = $optId;
            $packOptionMap[ucwords(strtolower($label))] = $optId;
            $packOptionMap[str_ireplace('of', 'Of', $label)] = $optId;
            $packOptionMap[str_ireplace('Of', 'of', $label)] = $optId;
        }

        // --------------------------------------------------------------------
        // 2. Ensure "color" attribute and options exist
        // --------------------------------------------------------------------
        $colorAttr = DB::table('attributes')->where('code', 'color')->first();
        $colorAttrId = $colorAttr->id;

        DB::table('attributes')->where('id', $colorAttrId)->update([
            'is_configurable' => 1,
            'is_filterable' => 1,
            'is_visible_on_front' => 1,
            'swatch_type' => 'color',
            'updated_at' => $now,
        ]);

        $colorDefinitions = [
            'All Colors' => ['sort' => 1, 'swatch' => '#4A5568'],
            'Black' => ['sort' => 2, 'swatch' => '#000000'],
            'Navy Blue' => ['sort' => 3, 'swatch' => '#1B2A4A'],
            'Sand Beige' => ['sort' => 4, 'swatch' => '#D2B48C'],
            'White' => ['sort' => 5, 'swatch' => '#FFFFFF'],
        ];
        $colorOptionMap = [];
        foreach ($colorDefinitions as $label => $meta) {
            $existingOpt = DB::table('attribute_options')
                ->where('attribute_id', $colorAttrId)
                ->where('admin_name', $label)
                ->first();

            if ($existingOpt) {
                $colorOptionMap[$label] = $existingOpt->id;
                DB::table('attribute_options')->where('id', $existingOpt->id)->update([
                    'swatch_value' => $meta['swatch'],
                    'sort_order' => $meta['sort'],
                ]);
            } else {
                $optId = DB::table('attribute_options')->insertGetId([
                    'attribute_id' => $colorAttrId,
                    'admin_name' => $label,
                    'sort_order' => $meta['sort'],
                    'swatch_value' => $meta['swatch'],
                ]);

                DB::table('attribute_option_translations')->insert([
                    'attribute_option_id' => $optId,
                    'locale' => 'en',
                    'label' => $label,
                ]);

                $colorOptionMap[$label] = $optId;
            }

            $colorOptionMap[$label] = $colorOptionMap[$label] ?? $optId;
            $colorOptionMap[strtolower($label)] = $colorOptionMap[$label];
            $colorOptionMap[ucwords(strtolower($label))] = $colorOptionMap[$label];
        }

        // --------------------------------------------------------------------
        // 3. Clean demo products and categories
        // --------------------------------------------------------------------
        $this->command->info('Cleaning demo products...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_flat')->truncate();
        DB::table('product_attribute_values')->delete();
        DB::table('product_categories')->delete();
        DB::table('product_inventories')->delete();
        DB::table('product_images')->delete();
        DB::table('product_videos')->delete();
        DB::table('product_up_sells')->delete();
        DB::table('product_cross_sells')->delete();
        DB::table('product_relations')->delete();
        DB::table('product_ordered_inventories')->delete();
        DB::table('product_price_indices')->truncate();
        DB::table('product_inventory_indices')->truncate();
        DB::table('product_super_attributes')->delete();
        DB::table('products')->whereNotNull('parent_id')->delete();
        DB::table('products')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('product_channels')->delete();
        if (DB::getSchemaBuilder()->hasTable('product_customer_group_prices')) {
            DB::table('product_customer_group_prices')->delete();
        }

        $this->command->info('Cleaning demo categories...');
        DB::table('category_translations')->where('category_id', '!=', 1)->delete();
        $childCats = DB::table('categories')->where('id', '!=', 1)->whereNotNull('parent_id')->where('parent_id', '!=', 1)->pluck('id');
        if ($childCats->count()) {
            DB::table('category_filterable_attributes')->whereIn('category_id', $childCats)->delete();
            DB::table('categories')->whereIn('id', $childCats)->delete();
        }
        $level1Cats = DB::table('categories')->where('id', '!=', 1)->pluck('id');
        if ($level1Cats->count()) {
            DB::table('category_filterable_attributes')->whereIn('category_id', $level1Cats)->delete();
            DB::table('categories')->whereIn('id', $level1Cats)->delete();
        }

        // --------------------------------------------------------------------
        // 4. Create SOXNSOX categories (Main & Subcategories)
        // --------------------------------------------------------------------
        $this->command->info('Configuring SOXNSOX root and category taxonomy...');
        DB::table('category_translations')->where('category_id', $rootId)->where('locale', 'en')->update([
            'name' => 'Root',
            'slug' => 'root',
            'url_path' => 'root',
            'description' => '<p>Root category for SOXNSOX store</p>',
            'meta_title' => 'SOXNSOX',
            'meta_description' => 'SOXNSOX Bamboo Socks store root category',
        ]);
        DB::table('categories')->where('id', $rootId)->update(['position' => 1, 'status' => 1]);

        $mainCategories = [
            ['name' => 'Men', 'slug' => 'men', 'description' => 'Men collection', 'position' => 1],
            ['name' => 'Women', 'slug' => 'women', 'description' => 'Women collection', 'position' => 2],
            ['name' => 'Children', 'slug' => 'children', 'description' => 'Children collection', 'position' => 3],
            ['name' => 'Medical Socks', 'slug' => 'medical-socks', 'description' => 'Medical & Diabetic Socks collection', 'position' => 4],
        ];

        $categoryIds = [];

        foreach ($mainCategories as $catData) {
            $catId = DB::table('categories')->insertGetId([
                'parent_id' => $rootId,
                'position' => $catData['position'],
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('category_translations')->insert([
                'category_id' => $catId,
                'locale' => 'en',
                'name' => $catData['name'],
                'slug' => $catData['slug'],
                'url_path' => $catData['slug'],
                'description' => '<p>'.$catData['description'].'</p>',
                'meta_title' => $catData['name'].' | SOXNSOX',
                'meta_description' => $catData['description'],
            ]);

            $categoryIds[$catData['slug']] = $catId;
        }

        // Subcategories under Medical Socks
        $subCategories = [
            ['name' => 'Compression Socks', 'slug' => 'compression-socks', 'description' => 'Compression Socks collection', 'position' => 1, 'parent_slug' => 'medical-socks'],
            ['name' => 'Plantar Fasciitis', 'slug' => 'plantar-fasciitis', 'description' => 'Plantar Fasciitis collection', 'position' => 2, 'parent_slug' => 'medical-socks'],
            ['name' => 'Performance', 'slug' => 'performance', 'description' => 'Performance collection', 'position' => 3, 'parent_slug' => 'medical-socks'],
            ['name' => 'Everyday Comfort', 'slug' => 'everyday-comfort', 'description' => 'Everyday Comfort collection', 'position' => 4, 'parent_slug' => 'medical-socks'],
        ];

        foreach ($subCategories as $catData) {
            $parentCatId = $categoryIds[$catData['parent_slug']] ?? $rootId;

            $catId = DB::table('categories')->insertGetId([
                'parent_id' => $parentCatId,
                'position' => $catData['position'],
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('category_translations')->insert([
                'category_id' => $catId,
                'locale' => 'en',
                'name' => $catData['name'],
                'slug' => $catData['slug'],
                'url_path' => $catData['parent_slug'].'/'.$catData['slug'],
                'description' => '<p>'.$catData['description'].'</p>',
                'meta_title' => $catData['name'].' | SOXNSOX',
                'meta_description' => $catData['description'],
            ]);

            $categoryIds[$catData['slug']] = $catId;
        }

        // Recompute nested set tree values
        Category::fixTree();

        // Enable Price (11), Color (23), and Pack Size filterable attributes for all categories
        foreach (array_merge([$rootId], array_values($categoryIds)) as $cId) {
            foreach ([11, $colorAttrId, $packSizeAttrId] as $filterAttrId) {
                DB::table('category_filterable_attributes')->insert([
                    'category_id' => $cId,
                    'attribute_id' => $filterAttrId,
                ]);
            }
        }
        $this->command->info('SOXNSOX categories created with Price, Color & Pack Size filters.');

        // --------------------------------------------------------------------
        // 5. Configurable Products Data Definition (Direct from soxnsox.in)
        // --------------------------------------------------------------------
        $products = [
            0 => [
                'sku' => 'soxnsox-all-day-comfort-socks',
                'name' => 'All-Day Comfort Bamboo Socks',
                'url_key' => 'all-day-comfort-socks',
                'short_desc' => 'Crafted with premium bamboo cotton, SOX N SOX All-Day Comfort Socks are designed for breathable softness, lightweight flexibility, and long-lasting everyday comfort. Perfect for work, travel, home, and daily movement, these socks help keep your feet fresh, relaxed, and comfortable throughout the day.',
                'description' => '<h3>Soft Comfort From Morning To Night</h3> <h3 data-section-id="1j8kiaa" data-start="484" data-end="519">Premium Bamboo Cotton Comfort</h3> <p data-start="520" data-end="553">Soft • Breathable • Everyday Wear</p> <h2 data-section-id="eq88en" data-start="828" data-end="860">Everyday Comfort You Can Feel</h2> <p data-start="862" data-end="968">All-Day Comfort Bamboo Socks are designed to provide soft, breathable comfort for your everyday lifestyle.</p> <p data-start="970" data-end="1159">Made using premium bamboo cotton fabric, these socks deliver lightweight softness, moisture control, and flexible support to help your feet stay fresh and comfortable from morning to night.</p> <p data-start="1161" data-end="1330">Whether you’re at work, travelling, relaxing at home, or on the move throughout the day, SOX N SOX combines comfort, durability, and modern everyday style in every pair.</p> <h5 data-section-id="1dnykt1" data-start="560" data-end="574">KEY BENEFITS</h5> <ul data-start="576" data-end="794"> <li data-section-id="14wqo27" data-start="576" data-end="606">Premium Bamboo Cotton Fabric</li> <li data-section-id="10afwpf" data-start="607" data-end="633">Ultra Soft Everyday Feel</li> <li data-section-id="1c2qe56" data-start="634" data-end="666">Breathable Lightweight Comfort</li> <li data-section-id="1nvueww" data-start="667" data-end="692">Moisture-Wicking Fabric</li> <li data-section-id="14ftw89" data-start="693" data-end="715">Flexible Stretch Fit</li> <li data-section-id="1fjuhdi" data-start="716" data-end="742">Skin-Friendly Soft Touch</li> <li data-section-id="wifcqx" data-start="743" data-end="768">Odor-Resistant Material</li> <li data-section-id="1gjvfo8" data-start="769" data-end="794">Designed For Daily Wear</li></ul> <h5 data-section-id="1ma7m6t" data-start="1361" data-end="1376">Key Features</h5> <ul data-start="1378" data-end="1597"> <li data-section-id="kw2ptf" data-start="1378" data-end="1407">Premium bamboo cotton blend</li> <li data-section-id="145kjgq" data-start="1408" data-end="1438">Ultra-soft breathable fabric</li> <li data-section-id="1nibm1f" data-start="1439" data-end="1465">Moisture-wicking comfort</li> <li data-section-id="k8rv4t" data-start="1466" data-end="1493">Lightweight everyday feel</li> <li data-section-id="v577ul" data-start="1494" data-end="1520">Flexible stretch support</li> <li data-section-id="hbyqx3" data-start="1521" data-end="1546">Comfortable all-day fit</li> <li data-section-id="1xe9po" data-start="1547" data-end="1575">Skin-friendly soft texture</li> <li data-section-id="1dhqlfs" data-start="1576" data-end="1597">Everyday durability</li></ul> <h3 data-section-id="1ip72t6" data-start="1604" data-end="1636">ADDITIONAL INFORMATION</h3> <h5 data-section-id="1ix3rke" data-start="1638" data-end="1649">Material</h5> <p data-start="1650" data-end="1677">Premium Bamboo Cotton Blend</p> <hr data-start="1679" data-end="1682" /> <h5 data-section-id="12fcay7" data-start="1684" data-end="1699">Suitable For</h5> <p data-start="1700" data-end="1760">Office Wear, Casual Wear, Travel, Home Comfort, Everyday Use</p> <hr data-start="1762" data-end="1765" /> <h5 data-section-id="26wt0m" data-start="1767" data-end="1778">Fit Type</h5> <p data-start="1779" data-end="1799">Flexible Comfort Fit</p> <hr data-start="1801" data-end="1804" /> <h5 data-section-id="1hzu7ek" data-start="1806" data-end="1824">Fabric Benefits</h5> <p data-start="1825" data-end="1875">Soft • Breathable • Lightweight • Moisture Control</p>',
                'categories' => [
                    0 => 'everyday-comfort',
                    1 => 'medical-socks',
                ],
                'meta_title' => 'All-Day Comfort Bamboo Socks | SOXNSOX',
                'meta_desc' => 'Crafted with premium bamboo cotton, SOX N SOX All-Day Comfort Socks are designed for breathable softness, lightweight flexibility, and long-lasting everyday com',
                'new' => 1,
                'featured' => 1,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 299,
                    'Pack Of 6' => 449,
                ],
                'images' => [
                    0 => 'ba0cee0c-5031-44c4-b5df-aea003174e1b.png',
                    1 => 'ae14232e-ab76-4e73-b5f4-a4d7cc457f49.png',
                    2 => 'b95065eb-d6fc-46ed-81d4-cac36078372f.png',
                    3 => 'de67e151-77d5-477c-bf41-f025c690d2c7.png',
                ],
                'variant_images' => [
                ],
            ],
            1 => [
                'sku' => 'soxnsox-anti-slip-activity-socks',
                'name' => 'Anti-Slip Activity Socks',
                'url_key' => 'anti-slip-activity-socks',
                'short_desc' => 'Designed with premium bamboo cotton and anti-slip grip support, SOX N SOX Anti-Slip Activity Socks provide breathable comfort, flexible movement, and extra stability for active children throughout the day. Perfect for indoor play, school, walking, and everyday activities.',
                'description' => '<h3>Secure Comfort For Active Little Feet</h3> <h3 data-section-id="hnmuo8" data-start="454" data-end="479">Active Grip Comfort</h3> <p data-start="480" data-end="511">Stable • Soft • Breathable Wear</p> <h3 data-section-id="guxviu" data-start="789" data-end="829">Comfort &amp; Stability For Everyday Play</h3> <p data-start="831" data-end="987">Anti-Slip Activity Socks are thoughtfully designed for children who stay active throughout the day and need soft breathable comfort with extra grip support.</p> <p data-start="989" data-end="1180">Crafted using premium bamboo cotton fabric and anti-slip grip soles, these socks help improve stability on smooth surfaces while keeping feet fresh, comfortable, and flexible during movement.</p> <p data-start="1182" data-end="1308">Whether at home, school, playtime, or indoor activities, SOX N SOX delivers secure comfort and reliable support in every step.</p> <h5 data-section-id="1dnykt1" data-start="518" data-end="532">KEY BENEFITS</h5> <ul data-start="534" data-end="755"> <li data-section-id="1hc9z3v" data-start="534" data-end="561">Anti-Slip Grip Technology</li> <li data-section-id="14wqo27" data-start="562" data-end="592">Premium Bamboo Cotton Fabric</li> <li data-section-id="1c2qe56" data-start="593" data-end="625">Breathable Lightweight Comfort</li> <li data-section-id="kh4r5p" data-start="626" data-end="652">Flexible Stretch Support</li> <li data-section-id="eer37t" data-start="653" data-end="680">Enhanced Stability &amp; Grip</li> <li data-section-id="1nvueww" data-start="681" data-end="706">Moisture-Wicking Fabric</li> <li data-section-id="1j7ujuw" data-start="707" data-end="728">Soft Cushioned Feel</li> <li data-section-id="1abxbw9" data-start="729" data-end="755">Designed For Active Kids</li></ul> <h5 data-section-id="1ma7m6t" data-start="1339" data-end="1354">Key Features</h5> <ul data-start="1356" data-end="1584"> <li data-section-id="15036ku" data-start="1356" data-end="1388">Anti-slip grip sole technology</li> <li data-section-id="kw2ptf" data-start="1389" data-end="1418">Premium bamboo cotton blend</li> <li data-section-id="bjg4yx" data-start="1419" data-end="1450">Breathable lightweight fabric</li> <li data-section-id="1fbbek1" data-start="1451" data-end="1478">Flexible movement support</li> <li data-section-id="1v8bhex" data-start="1479" data-end="1506">Enhanced grip &amp; stability</li> <li data-section-id="1nibm1f" data-start="1507" data-end="1533">Moisture-wicking comfort</li> <li data-section-id="1dump8o" data-start="1534" data-end="1555">Soft cushioned feel</li> <li data-section-id="13ymfem" data-start="1556" data-end="1584">Durable active wear design</li></ul> <h3 data-section-id="1ip72t6" data-start="1591" data-end="1623">ADDITIONAL INFORMATION SECTION</h3> <h5 data-section-id="1ix3rke" data-start="1625" data-end="1636">Material</h5> <p data-start="1637" data-end="1664">Premium Bamboo Cotton Blend</p> <hr data-start="1666" data-end="1669" /> <h5 data-section-id="12fcay7" data-start="1671" data-end="1686">Suitable For</h5> <p data-start="1687" data-end="1747">Indoor Play, School, Walking, Daily Activities, Home Comfort</p> <hr data-start="1749" data-end="1752" /> <h5 data-section-id="26wt0m" data-start="1754" data-end="1765">Fit Type</h5> <p data-start="1766" data-end="1791">Flexible Grip Comfort Fit</p> <hr data-start="1793" data-end="1796" /> <h5 data-section-id="1hzu7ek" data-start="1798" data-end="1816">Fabric Benefits</h5> <p data-start="1817" data-end="1868">Soft • Breathable • Grip Support • Moisture Control</p>',
                'categories' => [
                    0 => 'children',
                ],
                'meta_title' => 'Anti-Slip Activity Socks | SOXNSOX',
                'meta_desc' => 'Designed with premium bamboo cotton and anti-slip grip support, SOX N SOX Anti-Slip Activity Socks provide breathable comfort, flexible movement, and extra stab',
                'new' => 1,
                'featured' => 1,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 249,
                    'Pack Of 6' => 399,
                ],
                'images' => [
                    0 => 'Anti-Slip-Activity-Socks-for-kids.png',
                ],
                'variant_images' => [
                ],
            ],
            2 => [
                'sku' => 'soxnsox-arch-support-plantar-socks',
                'name' => 'Arch Support Plantar Bamboo Socks',
                'url_key' => 'arch-support-plantar-socks',
                'short_desc' => 'Designed with premium bamboo cotton and focused arch compression support, SOX N SOX Arch Support Plantar Socks help improve stability, reduce foot strain, and provide lasting comfort for daily movement. Perfect for walking, standing, travel, work, and plantar support needs.',
                'description' => '<h3>Targeted Arch Support For Everyday Movement</h3> <h3 data-section-id="nz16zz" data-start="471" data-end="506">Targeted Arch Comfort Support</h3> <p data-start="507" data-end="544">Stable • Breathable • Flexible Relief</p> <h3 data-section-id="1xjqpcb" data-start="841" data-end="878">Engineered For Better Foot Support</h3> <p data-start="880" data-end="1046">Arch Support Plantar Bamboo Socks are specially designed to provide targeted support around the arch area for improved comfort and stability during everyday movement.</p> <p data-start="1048" data-end="1198">Crafted using premium bamboo cotton fabric, these socks help reduce strain, improve foot alignment, and deliver breathable comfort throughout the day.</p> <p data-start="1200" data-end="1354">Whether you’re walking, working long hours, travelling, or staying active, SOX N SOX combines flexibility, support, and lightweight comfort in every step.</p> <h5 data-section-id="1dnykt1" data-start="551" data-end="565">KEY BENEFITS</h5> <ul data-start="567" data-end="807"> <li data-section-id="1tj2k4c" data-start="567" data-end="601">Focused Arch Compression Support</li> <li data-section-id="14wqo27" data-start="602" data-end="632">Premium Bamboo Cotton Fabric</li> <li data-section-id="1c2qe56" data-start="633" data-end="665">Breathable Lightweight Comfort</li> <li data-section-id="qfh6d4" data-start="666" data-end="694">Reduces Foot &amp; Heel Strain</li> <li data-section-id="kh4r5p" data-start="695" data-end="721">Flexible Stretch Support</li> <li data-section-id="1o4etff" data-start="722" data-end="751">Moisture-Wicking Technology</li> <li data-section-id="1j7ujuw" data-start="752" data-end="773">Soft Cushioned Feel</li> <li data-section-id="1assg78" data-start="774" data-end="807">Designed For Everyday Stability</li></ul> <h5 data-section-id="1ma7m6t" data-start="1385" data-end="1400">Key Features</h5> <ul data-start="1402" data-end="1643"> <li data-section-id="121xcl8" data-start="1402" data-end="1436">Focused arch compression support</li> <li data-section-id="kw2ptf" data-start="1437" data-end="1466">Premium bamboo cotton blend</li> <li data-section-id="15v7t3n" data-start="1467" data-end="1503">Breathable moisture-control fabric</li> <li data-section-id="gekqgs" data-start="1504" data-end="1530">Flexible stretch comfort</li> <li data-section-id="qcm3uh" data-start="1531" data-end="1563">Reduces pressure &amp; foot strain</li> <li data-section-id="1r2e1xc" data-start="1564" data-end="1591">Lightweight daily support</li> <li data-section-id="1u68fcc" data-start="1592" data-end="1616">Soft cushioned comfort</li> <li data-section-id="3plc7x" data-start="1617" data-end="1643">Comfortable all-day wear</li></ul> <h3 data-section-id="1ip72t6" data-start="1650" data-end="1682">ADDITIONAL INFORMATION SECTION</h3> <h5 data-section-id="1ix3rke" data-start="1684" data-end="1695">Material</h5> <p data-start="1696" data-end="1723">Premium Bamboo Cotton Blend</p> <hr data-start="1725" data-end="1728" /> <h5 data-section-id="12fcay7" data-start="1730" data-end="1745">Suitable For</h5> <p data-start="1746" data-end="1806">Walking, Long Standing Hours, Travel, Work, Everyday Comfort</p> <hr data-start="1808" data-end="1811" /> <h5 data-section-id="26wt0m" data-start="1813" data-end="1824">Fit Type</h5> <p data-start="1825" data-end="1850">Flexible Arch Support Fit</p> <hr data-start="1852" data-end="1855" /> <h5 data-section-id="1hzu7ek" data-start="1857" data-end="1875">Fabric Benefits</h5> <p data-start="1876" data-end="1930">Soft • Breathable • Stretch Comfort • Moisture Control</p>',
                'categories' => [
                    0 => 'medical-socks',
                    1 => 'plantar-fasciitis',
                ],
                'meta_title' => 'Arch Support Plantar Bamboo Socks | SOXNSOX',
                'meta_desc' => 'Designed with premium bamboo cotton and focused arch compression support, SOX N SOX Arch Support Plantar Socks help improve stability, reduce foot strain, and p',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Sand Beige',
                    3 => 'Navy Blue',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 6' => 549,
                    'Pack Of 4' => 349,
                ],
                'images' => [
                    0 => '32f48d56-4309-4c33-bbd9-ffd25cab87a9.png',
                    1 => '1777097445381-019dc342-a530-7d22-9766-df45118701d4.png',
                    2 => '65703e21-e96f-48f7-9c20-83c1366b8296.png',
                    3 => 'b64f98f0-4a7a-432d-8f8a-5c8daa9d8760.png',
                    4 => '47c614fe-d2e6-4b4e-bbc8-583108c5f411.png',
                ],
                'variant_images' => [
                    'all-colors_pack-of-6' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-12-All-colors.png',
                    'all-colors_pack-of-4' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-4-All-colors.png',
                    'black_pack-of-6' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-12-black.png',
                    'black_pack-of-4' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-4-black.png',
                    'sand-beige_pack-of-6' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-12-Sand-Beige.png',
                    'sand-beige_pack-of-4' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-4-Sand-Beige.png',
                    'navy-blue_pack-of-6' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-12-Navy-Blue.png',
                    'navy-blue_pack-of-4' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-4-Navy-Blue.png',
                    'white_pack-of-6' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-12-white.png',
                    'white_pack-of-4' => 'Arch-Support-Plantar-Bamboo-Socks-pack-of-4-white.png',
                ],
            ],
            3 => [
                'sku' => 'soxnsox-bamboo-ankle-sports-socks',
                'name' => 'Bamboo Ankle Sports Socks',
                'url_key' => 'bamboo-ankle-sports-socks',
                'short_desc' => 'Designed with premium bamboo cotton and breathable performance support, SOX N SOX Bamboo Ankle Sports Socks provide lightweight comfort, moisture control, and flexible movement for workouts, running, gym sessions, and active everyday wear. Comfort built for movement.',
                'description' => '<h3 data-section-id="1eb2vys" data-start="69" data-end="116">Lightweight Performance For Active Movement</h3> <h3 data-section-id="1h021gc" data-start="456" data-end="488">Active Performance Comfort</h3> <p data-start="489" data-end="524">Breathable • Flexible • Lightweight</p> <h3 data-section-id="i9631g" data-start="818" data-end="862">Performance Comfort For Everyday Activity</h3> <p data-start="864" data-end="1012">Bamboo Ankle Sports Socks are designed for people who want lightweight comfort, breathable performance, and flexible support during active movement.</p> <p data-start="1014" data-end="1177">Made using premium bamboo cotton fabric, these socks help manage moisture, reduce discomfort, and provide a soft secure fit throughout workouts and daily activity.</p> <p data-start="1179" data-end="1340">Whether you&#8217;re running, training, walking, travelling, or staying active throughout the day, SOX N SOX delivers breathable comfort and performance in every step.</p> <h5 data-section-id="1dnykt1" data-start="531" data-end="545">KEY BENEFITS</h5> <ul data-start="547" data-end="784"> <li data-section-id="14wqo27" data-start="547" data-end="577">Premium Bamboo Cotton Fabric</li> <li data-section-id="18niaux" data-start="578" data-end="616">Breathable Sports Performance Design</li> <li data-section-id="13c13xw" data-start="617" data-end="644">Lightweight Ankle Support</li> <li data-section-id="1o4etff" data-start="645" data-end="674">Moisture-Wicking Technology</li> <li data-section-id="5qi9rw" data-start="675" data-end="701">Flexible Stretch Comfort</li> <li data-section-id="1j7ujuw" data-start="702" data-end="723">Soft Cushioned Feel</li> <li data-section-id="1pywbh2" data-start="724" data-end="753">Anti-Friction Comfort Zones</li> <li data-section-id="z44m6n" data-start="754" data-end="784">Designed For Active Movement</li></ul> <h5 data-section-id="1ma7m6t" data-start="1371" data-end="1386">Key Features</h5> <ul data-start="1388" data-end="1615"> <li data-section-id="kw2ptf" data-start="1388" data-end="1417">Premium bamboo cotton blend</li> <li data-section-id="mnzagg" data-start="1418" data-end="1451">Lightweight ankle sports design</li> <li data-section-id="1snmmss" data-start="1452" data-end="1480">Breathable airflow comfort</li> <li data-section-id="1ntgq68" data-start="1481" data-end="1506">Moisture-wicking fabric</li> <li data-section-id="v577ul" data-start="1507" data-end="1533">Flexible stretch support</li> <li data-section-id="1dump8o" data-start="1534" data-end="1555">Soft cushioned feel</li> <li data-section-id="1tenmra" data-start="1556" data-end="1585">Anti-friction comfort zones</li> <li data-section-id="8hgs7p" data-start="1586" data-end="1615">Ideal for sports &amp; workouts</li></ul> <h3 data-section-id="1ip72t6" data-start="1622" data-end="1654">ADDITIONAL INFORMATION</h3> <h5 data-section-id="1ix3rke" data-start="1656" data-end="1667">Material</h5> <p data-start="1668" data-end="1695">Premium Bamboo Cotton Blend</p> <hr data-start="1697" data-end="1700" /> <h5 data-section-id="12fcay7" data-start="1702" data-end="1717">Suitable For</h5> <p data-start="1718" data-end="1777">Running, Gym, Walking, Sports, Training, Casual Active Wear</p> <hr data-start="1779" data-end="1782" /> <h5 data-section-id="26wt0m" data-start="1784" data-end="1795">Fit Type</h5> <p data-start="1796" data-end="1826">Flexible Performance Ankle Fit</p> <hr data-start="1828" data-end="1831" /> <h5 data-section-id="1hzu7ek" data-start="1833" data-end="1851">Fabric Benefits</h5> <p data-start="1852" data-end="1913">Breathable • Lightweight • Stretch Comfort • Moisture Control</p>',
                'categories' => [
                    0 => 'men',
                ],
                'meta_title' => 'Bamboo Ankle Sports Socks | SOXNSOX',
                'meta_desc' => 'Designed with premium bamboo cotton and breathable performance support, SOX N SOX Bamboo Ankle Sports Socks provide lightweight comfort, moisture control, and f',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Sand Beige',
                    3 => 'Navy Blue',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 12' => 799,
                    'Pack Of 4' => 299,
                ],
                'images' => [
                    0 => 'Bamboo-Ankle-Sports-Socks-for-men.png',
                ],
                'variant_images' => [
                    'all-colors_pack-of-12' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-12-all-colors.png',
                    'all-colors_pack-of-4' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-4-all-colors.png',
                    'black_pack-of-12' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-12-Black.png',
                    'black_pack-of-4' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-4-Black.png',
                    'sand-beige_pack-of-12' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-12-Sand-Beige.png',
                    'sand-beige_pack-of-4' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-4-Sand-Beige.png',
                    'navy-blue_pack-of-12' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-12-Navy-Blue.png',
                    'navy-blue_pack-of-4' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-4-Navy-Blue.png',
                    'white_pack-of-12' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-12-White.png',
                    'white_pack-of-4' => 'Bamboo-Ankle-Sports-Socks-for-men-pack-of-4-White.png',
                ],
            ],
            4 => [
                'sku' => 'soxnsox-bamboo-formal-office-socks',
                'name' => 'Bamboo Formal Office Socks',
                'url_key' => 'bamboo-formal-office-socks',
                'short_desc' => 'Crafted with premium bamboo cotton, SOX N SOX Bamboo Formal Office Socks are designed for breathable comfort, moisture control, and a clean professional look throughout the day. Soft, lightweight, and ideal for office wear, formal shoes, meetings, business travel, and daily professional use.',
                'description' => '<h3>Professional Comfort For Every Workday</h3> <h3 data-section-id="1i43303" data-start="477" data-end="505">Premium Office Comfort</h3> <p data-start="506" data-end="542">Soft • Breathable • Professional Fit</p> <h3 data-section-id="ftlngc" data-start="829" data-end="873">Professional Style Meets Everyday Comfort</h3> <p data-start="875" data-end="988">Bamboo Formal Office Socks are designed for professionals who want all-day comfort without compromising on style.</p> <p data-start="990" data-end="1188">Made using premium bamboo cotton fabric, these socks provide breathable softness, moisture control, and lightweight flexibility to help keep your feet fresh and comfortable during long office hours.</p> <p data-start="1190" data-end="1373">Whether you&#8217;re at work, attending meetings, travelling for business, or wearing formal shoes throughout the day, SOX N SOX delivers premium comfort with a refined professional finish.</p> <h5 data-section-id="1dnykt1" data-start="549" data-end="563">KEY BENEFITS</h5> <ul data-start="565" data-end="795"> <li data-section-id="14wqo27" data-start="565" data-end="595">Premium Bamboo Cotton Fabric</li> <li data-section-id="zowo4x" data-start="596" data-end="626">Elegant Formal Office Design</li> <li data-section-id="1c2qe56" data-start="627" data-end="659">Breathable Lightweight Comfort</li> <li data-section-id="1o4etff" data-start="660" data-end="689">Moisture-Wicking Technology</li> <li data-section-id="1t21qmu" data-start="690" data-end="713">Soft Professional Fit</li> <li data-section-id="1g8a41r" data-start="714" data-end="737">Odor-Resistant Fabric</li> <li data-section-id="kh4r5p" data-start="738" data-end="764">Flexible Stretch Support</li> <li data-section-id="qwqkrc" data-start="765" data-end="795">Designed For Long Work Hours</li></ul> <h5 data-section-id="1ma7m6t" data-start="1404" data-end="1419">Key Features</h5> <ul data-start="1421" data-end="1648"> <li data-section-id="kw2ptf" data-start="1421" data-end="1450">Premium bamboo cotton blend</li> <li data-section-id="gnnalm" data-start="1451" data-end="1479">Formal professional design</li> <li data-section-id="jzzpsq" data-start="1480" data-end="1512">Breathable lightweight comfort</li> <li data-section-id="1ntgq68" data-start="1513" data-end="1538">Moisture-wicking fabric</li> <li data-section-id="v577ul" data-start="1539" data-end="1565">Flexible stretch support</li> <li data-section-id="esn4qg" data-start="1566" data-end="1595">Soft all-day office comfort</li> <li data-section-id="s7g18p" data-start="1596" data-end="1621">Odor-resistant material</li> <li data-section-id="9bf589" data-start="1622" data-end="1648">Perfect for formal shoes</li></ul> <h3 data-section-id="1ip72t6" data-start="1655" data-end="1687">ADDITIONAL INFORMATION</h3> <h5 data-section-id="1ix3rke" data-start="1689" data-end="1700">Material</h5> <p data-start="1701" data-end="1728">Premium Bamboo Cotton Blend</p> <hr data-start="1730" data-end="1733" /> <h5 data-section-id="12fcay7" data-start="1735" data-end="1750">Suitable For</h5> <p data-start="1751" data-end="1814">Office Wear, Formal Wear, Business Meetings, Daily Work, Travel</p> <hr data-start="1816" data-end="1819" /> <h5 data-section-id="26wt0m" data-start="1821" data-end="1832">Fit Type</h5> <p data-start="1833" data-end="1860">Flexible Formal Comfort Fit</p> <hr data-start="1862" data-end="1865" /> <h5 data-section-id="1hzu7ek" data-start="1867" data-end="1885">Fabric Benefits</h5> <p data-start="1886" data-end="1936">Soft • Breathable • Lightweight • Moisture Control</p>',
                'categories' => [
                    0 => 'men',
                ],
                'meta_title' => 'Bamboo Formal Office Socks | SOXNSOX',
                'meta_desc' => 'Crafted with premium bamboo cotton, SOX N SOX Bamboo Formal Office Socks are designed for breathable comfort, moisture control, and a clean professional look th',
                'new' => 1,
                'featured' => 1,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 299,
                    'Pack Of 6' => 449,
                ],
                'images' => [
                    0 => 'Bamboo-Formal-Office-Socks-for-men.png',
                ],
                'variant_images' => [
                ],
            ],
            5 => [
                'sku' => 'soxnsox-breathable-daily-socks',
                'name' => 'Breathable Daily Socks',
                'url_key' => 'breathable-daily-socks',
                'short_desc' => 'Crafted with premium bamboo cotton, SOX N SOX Breathable Daily Socks are designed to provide lightweight comfort, breathable freshness, and flexible support for active everyday wear. Perfect for school, playtime, walking, travel, and daily activities.',
                'description' => '<h3>Fresh Comfort For Everyday Adventures</h3> <h3 data-section-id="119qpbf" data-start="431" data-end="464">Breathable Everyday Comfort</h3> <p data-start="465" data-end="496">Fresh • Soft • Lightweight Wear</p> <h3 data-section-id="x83cng" data-start="783" data-end="827">Lightweight Comfort For Everyday Movement</h3> <p data-start="829" data-end="971">Breathable Daily Socks are thoughtfully designed for children who need soft breathable comfort and lightweight flexibility throughout the day.</p> <p data-start="973" data-end="1159">Made using premium bamboo cotton fabric, these socks help improve airflow, manage moisture, and keep feet feeling fresh, dry, and comfortable during school, playtime, and daily routines.</p> <p data-start="1161" data-end="1264">Whether indoors or outdoors, SOX N SOX delivers breathable softness and reliable comfort in every step.</p> <h5 data-section-id="1dnykt1" data-start="503" data-end="517">KEY BENEFITS</h5> <ul data-start="519" data-end="749"> <li data-section-id="14wqo27" data-start="519" data-end="549">Premium Bamboo Cotton Fabric</li> <li data-section-id="1c2qe56" data-start="550" data-end="582">Breathable Lightweight Comfort</li> <li data-section-id="1o4etff" data-start="583" data-end="612">Moisture-Wicking Technology</li> <li data-section-id="wvjzqg" data-start="613" data-end="632">Soft Flexible Fit</li> <li data-section-id="1fjuhdi" data-start="633" data-end="659">Skin-Friendly Soft Touch</li> <li data-section-id="pq5l7r" data-start="660" data-end="688">Everyday Freshness Support</li> <li data-section-id="3f7e90" data-start="689" data-end="722">Durable Daily Wear Construction</li> <li data-section-id="1abxbw9" data-start="723" data-end="749">Designed For Active Kids</li></ul> <h5 data-section-id="1ma7m6t" data-start="1295" data-end="1310">Key Features</h5> <ul data-start="1312" data-end="1533"> <li data-section-id="kw2ptf" data-start="1312" data-end="1341">Premium bamboo cotton blend</li> <li data-section-id="bjg4yx" data-start="1342" data-end="1373">Breathable lightweight fabric</li> <li data-section-id="1nibm1f" data-start="1374" data-end="1400">Moisture-wicking comfort</li> <li data-section-id="v577ul" data-start="1401" data-end="1427">Flexible stretch support</li> <li data-section-id="afhbm4" data-start="1428" data-end="1456">Soft skin-friendly texture</li> <li data-section-id="1fn7s3t" data-start="1457" data-end="1478">Fresh everyday feel</li> <li data-section-id="13ymfem" data-start="1479" data-end="1507">Durable active wear design</li> <li data-section-id="hbyqx3" data-start="1508" data-end="1533">Comfortable all-day fit</li></ul> <h3 data-section-id="1ip72t6" data-start="1540" data-end="1572">ADDITIONAL INFORMATION SECTION</h3> <h5 data-section-id="1ix3rke" data-start="1574" data-end="1585">Material</h5> <p data-start="1586" data-end="1613">Premium Bamboo Cotton Blend</p> <hr data-start="1615" data-end="1618" /> <h5 data-section-id="12fcay7" data-start="1620" data-end="1635">Suitable For</h5> <p data-start="1636" data-end="1692">School Wear, Playtime, Walking, Travel, Daily Activities</p> <hr data-start="1694" data-end="1697" /> <h5 data-section-id="26wt0m" data-start="1699" data-end="1710">Fit Type</h5> <p data-start="1711" data-end="1740">Flexible Everyday Comfort Fit</p> <hr data-start="1742" data-end="1745" /> <h5 data-section-id="1hzu7ek" data-start="1747" data-end="1765">Fabric Benefits</h5> <p data-start="1766" data-end="1816">Soft • Breathable • Lightweight • Moisture Control</p>',
                'categories' => [
                    0 => 'children',
                ],
                'meta_title' => 'Breathable Daily Socks | SOXNSOX',
                'meta_desc' => 'Crafted with premium bamboo cotton, SOX N SOX Breathable Daily Socks are designed to provide lightweight comfort, breathable freshness, and flexible support for',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 249,
                    'Pack Of 6' => 399,
                ],
                'images' => [
                    0 => 'Breathable-Daily-Socks-for-Kids.png',
                ],
                'variant_images' => [
                ],
            ],
            6 => [
                'sku' => 'soxnsox-anti-slip-grip-socks',
                'name' => 'Diabetic Friendly Bamboo Socks',
                'url_key' => 'anti-slip-grip-socks',
                'short_desc' => 'Premium bamboo diabetic-friendly socks designed to provide gentle comfort, improved breathability, reduced pressure, and all-day freshness for sensitive feet.',
                'description' => '<h3>Gentle Comfort For Sensitive Feet</h3>
<h6>Designed with soft bamboo fabric, a gentle non-binding top, seamless comfort, and breathable construction to support everyday foot comfort.</h6>
<p>&nbsp;</p>
<h5>Designed for Healthy, Comfortable Feet</h5>
<p>&nbsp;</p>
<h3 class="PDq2pG_selectionAnchorContainer" data-section-id="1fah8gx" data-start="579" data-end="589">Key Features</h3>
<ul data-start="591" data-end="830">
<li data-section-id="1mtiuqw" data-start="591" data-end="617">Diabetic Friendly Design</li>
<li data-section-id="1tkh9ke" data-start="618" data-end="643">Non-Binding Comfort Top</li>
<li data-section-id="v7dx1z" data-start="644" data-end="664">Soft Bamboo Fabric</li>
<li data-section-id="45ezw8" data-start="665" data-end="692">Seamless Toe Construction</li>
<li data-section-id="1be19br" data-start="693" data-end="712">Breathable Fabric</li>
<li data-section-id="1kb1acw" data-start="713" data-end="731">Moisture Wicking</li>
<li data-section-id="xlnrp5" data-start="732" data-end="744">Anti Odor</li>
<li data-section-id="100tywy" data-start="745" data-end="764">Cushioned Comfort</li>
<li data-section-id="18m6cjd" data-start="765" data-end="784">All-Day Freshness</li>
<li data-section-id="e8xnf4" data-start="785" data-end="800">Skin Friendly</li>
<li data-section-id="dmd9hy" data-start="801" data-end="814">Lightweight</li>
<li data-section-id="nduga0" data-start="815" data-end="830">Everyday Wear</li>
</ul>
<h3 class="PDq2pG_selectionAnchorContainer" data-section-id="b8y6te" data-start="837" data-end="847">Key Benefits</h3>
<ul data-start="849" data-end="1095">
<li data-section-id="1rvw3y0" data-start="849" data-end="889">Helps reduce pressure around the ankle</li>
<li data-section-id="1o2w2um" data-start="890" data-end="918">Comfortable for long hours</li>
<li data-section-id="1ca814p" data-start="919" data-end="944">Keeps feet cool and dry</li>
<li data-section-id="cs3n1t" data-start="945" data-end="975">Helps reduce foot irritation</li>
<li data-section-id="7x40wi" data-start="976" data-end="1005">Soft against sensitive skin</li>
<li data-section-id="1196omw" data-start="1006" data-end="1045">Comfortable fit without tight elastic</li>
<li data-section-id="svbvmg" data-start="1046" data-end="1070">Suitable for daily use</li>
<li data-section-id="97ycb5" data-start="1071" data-end="1095">Premium bamboo comfort</li>
</ul>
<h3 class="PDq2pG_selectionAnchorContainer" data-section-id="1t3x4d9" data-start="1625" data-end="1637">Why Choose</h3>
<ul data-start="1639" data-end="1753">
<li data-section-id="pfbk0y" data-start="1639" data-end="1651">Gentle Fit</li>
<li data-section-id="1xd4vxg" data-start="1652" data-end="1673">Soft Bamboo Comfort</li>
<li data-section-id="1jes11l" data-start="1674" data-end="1692">Reduced Pressure</li>
<li data-section-id="1u0pt7s" data-start="1693" data-end="1713">Everyday Freshness</li>
<li data-section-id="1m7hzzw" data-start="1714" data-end="1732">Lightweight Feel</li>
<li data-section-id="3jg9hu" data-start="1733" data-end="1753">Premium Durability</li>
</ul>
<h3 class="PDq2pG_selectionAnchorContainer" data-section-id="1ypbcdq" data-start="1760" data-end="1780">Product Highlights</h3>
<div class="relative w-full mt-4 mb-1">
<div>
<div class="contents">
<div class="relative">
<div>
<div> <p>       ✓ Soft Bamboo Fabric</p> <p>✓ Diabetic Friendly Design</p> <p>✓ Non-Binding Comfort Top</p> <p>✓ Seamless Toe</p> <p>✓ Breathable Construction</p> <p>✓ Moisture Wicking</p> <p>✓ Anti Odor</p> <p>✓ Ultra Soft Cushion</p> <p>✓ Lightweight Feel</p> <p>✓ Everyday Comfort</p>',
                'categories' => [
                    0 => 'medical-socks',
                    1 => 'performance',
                ],
                'meta_title' => 'Diabetic Friendly Bamboo Socks | SOXNSOX',
                'meta_desc' => 'Premium bamboo diabetic-friendly socks designed to provide gentle comfort, improved breathability, reduced pressure, and all-day freshness for sensitive feet.',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Sand Beige',
                    3 => 'Navy Blue',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 6' => 549,
                    'Pack Of 4' => 349,
                ],
                'images' => [
                    0 => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-1.png',
                    1 => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-2.png',
                    2 => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-3.png',
                    3 => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-4.png',
                ],
                'variant_images' => [
                    'all-colors_pack-of-6' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-6-ALL-COLORS.png',
                    'all-colors_pack-of-4' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-4-ALL-COLORS.png',
                    'black_pack-of-6' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-6-BLACK.png',
                    'black_pack-of-4' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-4-BLACK.png',
                    'sand-beige_pack-of-6' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-6-SAND-BEIGE.png',
                    'sand-beige_pack-of-4' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-4-SAND-BEIGE.png',
                    'navy-blue_pack-of-6' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-6-NAVY-BLUE.png',
                    'navy-blue_pack-of-4' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-4-NAVY-BLUE.png',
                    'white_pack-of-6' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-6-WHITE.png',
                    'white_pack-of-4' => 'DIABETIC-FRIENDLY-BAMBOO-SOCKS-PACK-OF-4-WHITE.png',
                ],
            ],
            7 => [
                'sku' => 'soxnsox-everyday-compression-socks',
                'name' => 'Everyday Compression Bamboo Socks',
                'url_key' => 'everyday-compression-socks',
                'short_desc' => 'Made with premium bamboo cotton and balanced compression support, SOX N SOX Everyday Compression Socks are designed to improve circulation, reduce fatigue, and provide breathable comfort for daily wear. Perfect for work, travel, long sitting hours, walking, and everyday movement.',
                'description' => '<h3>Everyday Support With Lasting Comfort</h3> <h3 data-section-id="18p993b" data-start="471" data-end="505">Everyday Compression Comfort</h3> <p data-start="506" data-end="542">Support • Circulation • Daily Relief</p> <h3 data-section-id="jh3yq1" data-start="836" data-end="880">Everyday Comfort With Compression Support</h3> <p data-start="882" data-end="1029">Everyday Compression Bamboo Socks are designed for people who spend long hours standing, sitting, travelling, or staying active throughout the day.</p> <p data-start="1031" data-end="1214">Crafted using premium bamboo cotton fabric, these socks provide balanced compression support that helps improve circulation, reduce tiredness, and maintain breathable all-day comfort.</p> <p data-start="1216" data-end="1363">Whether you&#8217;re at work, travelling, walking, or managing a busy routine, SOX N SOX delivers lightweight support and reliable comfort in every step.</p> <h5 data-section-id="1dnykt1" data-start="549" data-end="563">KEY BENEFITS</h5> <ul data-start="565" data-end="802"> <li data-section-id="td1vez" data-start="565" data-end="595">Balanced Compression Support</li> <li data-section-id="14wqo27" data-start="596" data-end="626">Premium Bamboo Cotton Fabric</li> <li data-section-id="10z288k" data-start="627" data-end="655">Improves Blood Circulation</li> <li data-section-id="1akbwce" data-start="656" data-end="684">Helps Reduce Daily Fatigue</li> <li data-section-id="gqc3kh" data-start="685" data-end="722">Breathable Moisture-Wicking Comfort</li> <li data-section-id="kh4r5p" data-start="723" data-end="749">Flexible Stretch Support</li> <li data-section-id="15vq05u" data-start="750" data-end="773">Soft Lightweight Feel</li> <li data-section-id="k338n4" data-start="774" data-end="802">Designed For Everyday Wear</li></ul> <h5 data-section-id="1ma7m6t" data-start="1394" data-end="1409">Key Features</h5> <ul data-start="1411" data-end="1654"> <li data-section-id="1u44ht6" data-start="1411" data-end="1450">Balanced everyday compression support</li> <li data-section-id="kw2ptf" data-start="1451" data-end="1480">Premium bamboo cotton blend</li> <li data-section-id="15v7t3n" data-start="1481" data-end="1517">Breathable moisture-control fabric</li> <li data-section-id="1rz3izi" data-start="1518" data-end="1546">Helps reduce daily fatigue</li> <li data-section-id="gekqgs" data-start="1547" data-end="1573">Flexible stretch comfort</li> <li data-section-id="1sy5h7t" data-start="1574" data-end="1603">Lightweight all-day support</li> <li data-section-id="1dump8o" data-start="1604" data-end="1625">Soft cushioned feel</li> <li data-section-id="6pyjwq" data-start="1626" data-end="1654">Comfortable long-hour wear</li></ul> <h3 data-section-id="1ip72t6" data-start="1661" data-end="1693">ADDITIONAL INFORMATION</h3> <h5 data-section-id="1ix3rke" data-start="1695" data-end="1706">Material</h5> <p data-start="1707" data-end="1734">Premium Bamboo Cotton Blend</p> <hr data-start="1736" data-end="1739" /> <h5 data-section-id="12fcay7" data-start="1741" data-end="1756">Suitable For</h5> <p data-start="1757" data-end="1816">Work, Travel, Walking, Long Sitting Hours, Everyday Comfort</p> <hr data-start="1818" data-end="1821" /> <h5 data-section-id="26wt0m" data-start="1823" data-end="1834">Fit Type</h5> <p data-start="1835" data-end="1867">Flexible Compression Comfort Fit</p> <hr data-start="1869" data-end="1872" /> <h5 data-section-id="1hzu7ek" data-start="1874" data-end="1892">Fabric Benefits</h5> <p data-start="1893" data-end="1949">Breathable • Supportive • Lightweight • Moisture Control</p>',
                'categories' => [
                    0 => 'compression-socks',
                    1 => 'medical-socks',
                ],
                'meta_title' => 'Everyday Compression Bamboo Socks | SOXNSOX',
                'meta_desc' => 'Made with premium bamboo cotton and balanced compression support, SOX N SOX Everyday Compression Socks are designed to improve circulation, reduce fatigue, and ',
                'new' => 1,
                'featured' => 1,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Sand Beige',
                    3 => 'Navy Blue',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 6' => 449,
                    'Pack Of 4' => 299,
                ],
                'images' => [
                    0 => 'gpt-image-1.5-high-fidelity_a_please_make_this_ima.png',
                    1 => 'gpt-image-1.5-high-fidelity_a_please_make_this_ima-3.png',
                    2 => 'gpt-image-1.5-high-fidelity_a_please_make_this_ima-2.png',
                    3 => 'gpt-image-1.5-high-fidelity_a_please_make_this_ima-1.png',
                ],
                'variant_images' => [
                    'all-colors_pack-of-6' => 'Everyday-Compression-Bamboo-Socks-pack-of-12-all-colors.png',
                    'all-colors_pack-of-4' => 'Everyday-Compression-Bamboo-Socks-pack-of-4-all-colors.png',
                    'black_pack-of-6' => 'Everyday-Compression-Bamboo-Socks-pack-of-12-black.png',
                    'black_pack-of-4' => 'Everyday-Compression-Bamboo-Socks-pack-of-4-black.png',
                    'sand-beige_pack-of-6' => 'Everyday-Compression-Bamboo-Socks-pack-of-12-light-grey.png',
                    'sand-beige_pack-of-4' => 'Everyday-Compression-Bamboo-Socks-pack-of-4-light-grey.png',
                    'navy-blue_pack-of-6' => 'Everyday-Compression-Bamboo-Socks-pack-of-12-navy-blue.png',
                    'navy-blue_pack-of-4' => 'Everyday-Compression-Bamboo-Socks-pack-of-4-navy-blue.png',
                    'white_pack-of-6' => 'Everyday-Compression-Bamboo-Socks-pack-of-12-white.png',
                    'white_pack-of-4' => 'Everyday-Compression-Bamboo-Socks-pack-of-4-white.png',
                ],
            ],
            8 => [
                'sku' => 'soxnsox-gym-performance-bamboo-socks',
                'name' => 'Gym Performance Bamboo Socks',
                'url_key' => 'gym-performance-bamboo-socks',
                'short_desc' => 'Power every workout with SOX N SOX Gym Performance Bamboo Socks. Crafted from premium bamboo fabric with breathable ventilation, moisture-wicking comfort, cushioned support, and anti-odour freshness for training, gym sessions, yoga, walking, and everyday fitness.',
                'description' => '<h3>Train Hard. Stay Comfortable.</h3> <h6 class="PDq2pG_selectionAnchorContainer" data-start="647" data-end="766">Premium bamboo performance socks designed to keep your feet cool, dry, supported, and comfortable during every workout.</h6> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="u0ybrq" data-start="773" data-end="787">Key Features</h3> <ul data-start="789" data-end="970"> <li data-section-id="1d6tnuq" data-start="789" data-end="812">Premium Bamboo Fabric</li> <li data-section-id="1her5v8" data-start="813" data-end="836">Breathable Mesh Zones</li> <li data-section-id="1kb1acw" data-start="837" data-end="855">Moisture Wicking</li> <li data-section-id="xlnrp5" data-start="856" data-end="868">Anti Odor</li> <li data-section-id="gc9iwp" data-start="869" data-end="885">Cushioned Sole</li> <li data-section-id="1q4djbz" data-start="886" data-end="900">Arch Support</li> <li data-section-id="12xzym4" data-start="901" data-end="914">Stretch Fit</li> <li data-section-id="dmd9hy" data-start="915" data-end="928">Lightweight</li> <li data-section-id="12h8a8t" data-start="929" data-end="952">Reinforced Heel &amp; Toe</li> <li data-section-id="2dxc7q" data-start="953" data-end="970">All-Day Comfort</li></ul> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="v1mjmx" data-start="977" data-end="995">Product Benefits</h3> <ul data-start="997" data-end="1235"> <li data-section-id="sff6te" data-start="997" data-end="1030">Keeps feet cool during workouts</li> <li data-section-id="owi2p1" data-start="1031" data-end="1054">Helps manage moisture</li> <li data-section-id="cranc4" data-start="1055" data-end="1076">Soft bamboo comfort</li> <li data-section-id="17efi5p" data-start="1077" data-end="1106">Cushioned impact protection</li> <li data-section-id="cf6cps" data-start="1107" data-end="1131">Comfortable secure fit</li> <li data-section-id="1yurrkl" data-start="1132" data-end="1160">Supports everyday training</li> <li data-section-id="z968sv" data-start="1161" data-end="1192">Fresh feeling for longer wear</li> <li data-section-id="1fnllb0" data-start="1193" data-end="1235">Suitable for indoor and outdoor workouts</li></ul> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="1t3x4d9" data-start="1404" data-end="1416">Why Choose</h3> <ul data-start="1418" data-end="1541"> <li data-section-id="1do99f5" data-start="1418" data-end="1439">Soft Premium Bamboo</li> <li data-section-id="zicjby" data-start="1440" data-end="1461">Performance Comfort</li> <li data-section-id="1f4damw" data-start="1462" data-end="1481">Breathable Design</li> <li data-section-id="lbjfcz" data-start="1482" data-end="1501">Cushioned Support</li> <li data-section-id="5tq3eu" data-start="1502" data-end="1516">Flexible Fit</li> <li data-section-id="btk2o7" data-start="1517" data-end="1541">Built for Active Women</li></ul> <h3>Product Highlights</h3> <p>✓ Premium Bamboo Fabric</p> <p>✓ Breathable Mesh</p> <p>✓ Moisture Wicking</p> <p>✓ Anti Odor</p> <p>✓ Cushioned Sole</p> <p>✓ Arch Support</p> <p>✓ Reinforced Heel &amp; Toe</p> <p>✓ Lightweight</p> <p>✓ Stretch Comfort</p> <p>✓ Gym Performance</p> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="1spgaq0" data-start="1925" data-end="1941">Specifications</h3> <p data-start="1943" data-end="1977"><strong data-start="1943" data-end="1956">Material:</strong> Premium Bamboo Blend</p> <p data-start="1979" data-end="1996"><strong data-start="1979" data-end="1990">Length:</strong> Ankle</p> <p data-start="1998" data-end="2027"><strong data-start="1998" data-end="2006">Fit:</strong> Athletic Stretch Fit</p> <p data-start="2029" data-end="2046"><strong data-start="2029" data-end="2040">Gender:</strong> Women</p> <p data-start="2048" data-end="2075"><strong data-start="2048" data-end="2061">Activity:</strong> Fitness &amp; Gym</p> <p data-start="2077" data-end="2099"><strong data-start="2077" data-end="2088">Season:</strong> All Season</p>',
                'categories' => [
                    0 => 'women',
                ],
                'meta_title' => 'Gym Performance Bamboo Socks | SOXNSOX',
                'meta_desc' => 'Power every workout with SOX N SOX Gym Performance Bamboo Socks. Crafted from premium bamboo fabric with breathable ventilation, moisture-wicking comfort, cushi',
                'new' => 1,
                'featured' => 1,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 299,
                    'Pack Of 6' => 449,
                ],
                'images' => [
                    0 => 'GYM-PERFORMANCE-BAMBOO-SOCKS-1.png',
                    1 => 'GYM-PERFORMANCE-BAMBOO-SOCKS-2.png',
                    2 => 'GYM-PERFORMANCE-BAMBOO-SOCKS-3.png',
                    3 => 'GYM-PERFORMANCE-BAMBOO-SOCKS-4.png',
                ],
                'variant_images' => [
                    'all-colors_pack-of-4' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-4-ALL-COLORS.png',
                    'black_pack-of-4' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-4-BLACK.png',
                    'navy-blue_pack-of-4' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-4-NAVY-BLUE.png',
                    'sand-beige_pack-of-4' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-4-SAND-BEIGE.png',
                    'white_pack-of-4' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-4-WHITE.png',
                    'all-colors_pack-of-6' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-6-ALL-COLORS.png',
                    'black_pack-of-6' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-6-BLACK.png',
                    'navy-blue_pack-of-6' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-6-NAVY-BLUE.png',
                    'sand-beige_pack-of-6' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-6-SAND-BEIGE.png',
                    'white_pack-of-6' => 'GYM-PERFORMANCE-BAMBOO-SOCKS-PACK-OF-6-WHITE.png',
                ],
            ],
            9 => [
                'sku' => 'soxnsox-infant-comfort-bamboo-socks-for-babies',
                'name' => 'Infant Comfort Bamboo Socks for Babies',
                'url_key' => 'infant-comfort-bamboo-socks-for-babies',
                'short_desc' => 'Keep little feet soft, cozy, and protected with SOX N SOX Infant Comfort Bamboo Socks. Made from premium bamboo fabric, these ultra-soft socks are breathable, gentle on delicate skin, and designed with a comfortable non-binding fit for everyday wear.',
                'description' => '<h3 class="PDq2pG_selectionAnchorContainer" data-section-id="tqc7jo" data-start="274" data-end="288">Suitable Age</h3> <p data-start="290" data-end="305"><strong data-start="290" data-end="305">0–24 Months</strong></p> <h3 data-start="290" data-end="305">Gentle Comfort for Little Feet</h3> <h6>Soft bamboo socks thoughtfully designed to keep your baby&#8217;s feet cozy, breathable, and comfortable all day.</h6> <p>&nbsp;</p> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="u0ybrq" data-start="778" data-end="792">Key Features</h3> <ul data-start="794" data-end="985"> <li data-section-id="1yxdend" data-start="794" data-end="820">Ultra Soft Bamboo Fabric</li> <li data-section-id="nqodao" data-start="821" data-end="846">Gentle on Delicate Skin</li> <li data-section-id="9flcsy" data-start="847" data-end="864">Breathable Knit</li> <li data-section-id="1kb1acw" data-start="865" data-end="883">Moisture Wicking</li> <li data-section-id="xlnrp5" data-start="884" data-end="896">Anti Odour</li> <li data-section-id="1tkh9ke" data-start="897" data-end="922">Non-Binding Comfort Top</li> <li data-section-id="12xzym4" data-start="923" data-end="936">Stretch Fit</li> <li data-section-id="dmd9hy" data-start="937" data-end="950">Lightweight</li> <li data-section-id="1k7rz5h" data-start="951" data-end="969">Seamless Comfort</li> <li data-section-id="nduga0" data-start="970" data-end="985">Everyday Wear</li></ul> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="v1mjmx" data-start="992" data-end="1010">Product Benefits</h3> <ul data-start="1012" data-end="1281"> <li data-section-id="btccah" data-start="1012" data-end="1050">Keeps tiny feet soft and comfortable</li> <li data-section-id="1jmvr6v" data-start="1051" data-end="1084">Gentle on baby&#8217;s sensitive skin</li> <li data-section-id="1i1jhu0" data-start="1085" data-end="1115">Helps keep feet cool and dry</li> <li data-section-id="r54c93" data-start="1116" data-end="1154">Comfortable stretch for growing feet</li> <li data-section-id="3onv70" data-start="1155" data-end="1188">Easy to wear throughout the day</li> <li data-section-id="6ggjy0" data-start="1189" data-end="1227">Soft cuff stays comfortably in place</li> <li data-section-id="13m8tts" data-start="1228" data-end="1255">Suitable for everyday use</li> <li data-section-id="rmsxoa" data-start="1256" data-end="1281">Premium bamboo softness</li></ul> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="1dtoi3m" data-start="1461" data-end="1482">Why Parents Love It</h3> <ul data-start="1484" data-end="1673"> <li data-section-id="6i9y4s" data-start="1484" data-end="1512">Soft premium bamboo fabric</li> <li data-section-id="z9rpai" data-start="1513" data-end="1544">Gentle fit for growing babies</li> <li data-section-id="dgpcbd" data-start="1545" data-end="1575">Lightweight everyday comfort</li> <li data-section-id="kkutqz" data-start="1576" data-end="1606">Breathable all-day freshness</li> <li data-section-id="1e36xab" data-start="1607" data-end="1637">Premium quality construction</li> <li data-section-id="105lort" data-start="1638" data-end="1673">Designed for delicate little feet</li></ul> <h3>Product Highlights</h3> <p>✓ Ultra Soft Bamboo</p> <p>✓ Gentle on Delicate Skin</p> <p>✓ Breathable Fabric</p> <p>✓ Moisture Wicking</p> <p>✓ Anti Odor</p> <p>✓ Stretch Comfort</p> <p>✓ Non-Binding Top</p> <p>✓ Lightweight</p> <p>✓ Everyday Wear</p> <p>✓ Premium Quality</p> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="1cz9o7s" data-start="2024" data-end="2043">Care Instructions</h3> <ul data-start="2045" data-end="2158"> <li data-section-id="5ykls4" data-start="2045" data-end="2064">Machine wash cold</li> <li data-section-id="gtde8t" data-start="2065" data-end="2092">Wash with similar colors</li> <li data-section-id="1vrvu3b" data-start="2093" data-end="2108">Do not bleach</li> <li data-section-id="q3dvkk" data-start="2109" data-end="2125">Tumble dry low</li> <li data-section-id="g8u3nw" data-start="2126" data-end="2139">Do not iron</li> <li data-section-id="u31nks" data-start="2140" data-end="2158">Do not dry clean</li></ul> <h3 class="PDq2pG_selectionAnchorContainer" data-section-id="1spgaq0" data-start="2165" data-end="2181">Specifications</h3> <p data-start="2183" data-end="2217"><strong data-start="2183" data-end="2196">Material:</strong> Premium Bamboo Blend</p> <p data-start="2219" data-end="2236"><strong data-start="2219" data-end="2230">Length:</strong> Ankle</p> <p data-start="2238" data-end="2263"><strong data-start="2238" data-end="2246">Fit:</strong> Soft Stretch Fit</p> <p data-start="2265" data-end="2289"><strong data-start="2265" data-end="2276">Gender:</strong> Boys &amp; Girls</p> <p data-start="2291" data-end="2317"><strong data-start="2291" data-end="2305">Age Group:</strong> 0–24 Months</p> <p data-start="2319" data-end="2341"><strong data-start="2319" data-end="2330">Season:</strong> All Season</p>',
                'categories' => [
                    0 => 'children',
                ],
                'meta_title' => 'Infant Comfort Bamboo Socks for Babies | SOXNSOX',
                'meta_desc' => 'Keep little feet soft, cozy, and protected with SOX N SOX Infant Comfort Bamboo Socks. Made from premium bamboo fabric, these ultra-soft socks are breathable, g',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 6' => 349,
                ],
                'images' => [
                    0 => 'INFANT-COMFORT-BAMBOO-SOCKS-1.png',
                    1 => 'INFANT-COMFORT-BAMBOO-SOCKS-11.png',
                    2 => 'INFANT-COMFORT-BAMBOO-SOCKS-4.png',
                    3 => 'INFANT-COMFORT-BAMBOO-SOCKS-3.png',
                    4 => 'INFANT-COMFORT-BAMBOO-SOCKS-2.png',
                ],
                'variant_images' => [
                    'all-colors_pack-of-6' => 'INFANT-COMFORT-BAMBOO-SOCKS-all-colors.png',
                    'black_pack-of-6' => 'INFANT-COMFORT-BAMBOO-SOCKS-Pack-of-6-Black.png',
                    'navy-blue_pack-of-6' => 'INFANT-COMFORT-BAMBOO-SOCKS-Pack-of-6-Navy-Blue.png',
                    'sand-beige_pack-of-6' => 'INFANT-COMFORT-BAMBOO-SOCKS-Pack-of-6-Sand-Beige.png',
                    'white_pack-of-6' => 'INFANT-COMFORT-BAMBOO-SOCKS-Pack-of-6-WHITE.png',
                ],
            ],
            10 => [
                'sku' => 'soxnsox-lightweight-everyday-socks',
                'name' => 'Lightweight Everyday Socks',
                'url_key' => 'lightweight-everyday-socks',
                'short_desc' => 'Crafted with premium bamboo cotton, SOX N SOX Lightweight Everyday Socks are designed to deliver breathable softness, lightweight flexibility, and lasting comfort for daily wear. Perfect for casual routines, walking, office wear, travel, and all-day comfort.',
                'description' => '<h3>Light Comfort For Everyday Movement</h3> <h3 data-section-id="11jiy5r" data-start="440" data-end="471">Lightweight Daily Comfort</h3> <p data-start="472" data-end="505">Soft • Breathable • Flexible Wear</p> <h2 data-section-id="9bfjbu" data-start="774" data-end="819">Lightweight Comfort You Can Wear Every Day</h2> <p data-start="821" data-end="962">Lightweight Everyday Socks are thoughtfully designed for women who want breathable softness, flexible comfort, and lightweight everyday wear.</p> <p data-start="964" data-end="1148">Made using premium bamboo cotton fabric, these socks help keep your feet fresh, comfortable, and relaxed throughout the day with moisture-control performance and soft flexible support.</p> <p data-start="1150" data-end="1309">Whether you&#8217;re working, travelling, walking, shopping, or relaxing at home, SOX N SOX delivers lightweight comfort and effortless everyday style in every pair.</p> <h5 data-section-id="1dnykt1" data-start="512" data-end="526">KEY BENEFITS</h5> <ul data-start="528" data-end="740"> <li data-section-id="14wqo27" data-start="528" data-end="558">Premium Bamboo Cotton Fabric</li> <li data-section-id="172a4nt" data-start="559" data-end="589">Lightweight Everyday Comfort</li> <li data-section-id="rdn4em" data-start="590" data-end="612">Breathable Soft Feel</li> <li data-section-id="1o4etff" data-start="613" data-end="642">Moisture-Wicking Technology</li> <li data-section-id="14ftw89" data-start="643" data-end="665">Flexible Stretch Fit</li> <li data-section-id="1by97k0" data-start="666" data-end="688">Skin-Friendly Fabric</li> <li data-section-id="wifcqx" data-start="689" data-end="714">Odor-Resistant Material</li> <li data-section-id="1gjvfo8" data-start="715" data-end="740">Designed For Daily Wear</li></ul> <h5 data-section-id="1ma7m6t" data-start="1340" data-end="1355">Key Features</h5> <ul data-start="1357" data-end="1565"> <li data-section-id="kw2ptf" data-start="1357" data-end="1386">Premium bamboo cotton blend</li> <li data-section-id="thjfpi" data-start="1387" data-end="1418">Lightweight breathable design</li> <li data-section-id="1nibm1f" data-start="1419" data-end="1445">Moisture-wicking comfort</li> <li data-section-id="v577ul" data-start="1446" data-end="1472">Flexible stretch support</li> <li data-section-id="1hd78q5" data-start="1473" data-end="1493">Soft everyday feel</li> <li data-section-id="1qlsfk0" data-start="1494" data-end="1516">Skin-friendly fabric</li> <li data-section-id="3plc7x" data-start="1517" data-end="1543">Comfortable all-day wear</li> <li data-section-id="3hol0s" data-start="1544" data-end="1565">Ideal for daily use</li></ul> <h3 data-section-id="1ip72t6" data-start="1572" data-end="1604">ADDITIONAL INFORMATION SECTION</h3> <h5 data-section-id="1ix3rke" data-start="1606" data-end="1617">Material</h5> <p data-start="1618" data-end="1645">Premium Bamboo Cotton Blend</p> <hr data-start="1647" data-end="1650" /> <h5 data-section-id="12fcay7" data-start="1652" data-end="1667">Suitable For</h5> <p data-start="1668" data-end="1727">Casual Wear, Office Wear, Travel, Walking, Everyday Comfort</p> <hr data-start="1729" data-end="1732" /> <h5 data-section-id="26wt0m" data-start="1734" data-end="1745">Fit Type</h5> <p data-start="1746" data-end="1778">Flexible Lightweight Comfort Fit</p> <hr data-start="1780" data-end="1783" /> <h5 data-section-id="1hzu7ek" data-start="1785" data-end="1803">Fabric Benefits</h5> <p data-start="1804" data-end="1854">Soft • Breathable • Lightweight • Moisture Control</p>',
                'categories' => [
                    0 => 'women',
                ],
                'meta_title' => 'Lightweight Everyday Socks | SOXNSOX',
                'meta_desc' => 'Crafted with premium bamboo cotton, SOX N SOX Lightweight Everyday Socks are designed to deliver breathable softness, lightweight flexibility, and lasting comfo',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 249,
                    'Pack Of 6' => 399,
                ],
                'images' => [
                    0 => 'Lightweight-Everyday-Socks-for-women.png',
                ],
                'variant_images' => [
                ],
            ],
            11 => [
                'sku' => 'soxnsox-performance-running-socks',
                'name' => 'Performance Running Bamboo Socks',
                'url_key' => 'performance-running-socks',
                'short_desc' => 'Designed with premium bamboo cotton and performance-focused support zones, SOX N SOX Performance Running Socks deliver breathable comfort, moisture control, and flexible support for running, training, workouts, and active lifestyles. Lightweight, durable, and engineered for movement.',
                'description' => '<h3 data-start="3009" data-end="3217">Built For Movement &amp; Performance</h3> <h3 data-section-id="ac5j92" data-start="469" data-end="505">Performance Comfort Technology</h3> <p data-start="506" data-end="544">Breathable • Flexible • Active Support</p> <h3 data-section-id="16y08i8" data-start="831" data-end="868">Comfort Engineered For Performance</h3> <p data-start="870" data-end="1018">Performance Running Bamboo Socks are crafted for active lifestyles, combining breathable bamboo cotton comfort with lightweight performance support.</p> <p data-start="1020" data-end="1215">Designed to help reduce friction, improve airflow, and maintain comfort during movement, these socks provide a secure flexible fit for running, workouts, walking, training, and everyday activity.</p> <p data-start="1217" data-end="1373">Whether you&#8217;re at the gym, outdoors, travelling, or staying active throughout the day, SOX N SOX delivers comfort, stability, and performance in every step.</p> <h5 data-section-id="1dnykt1" data-start="551" data-end="565">KEY BENEFITS</h5> <ul data-start="567" data-end="797"> <li data-section-id="1vw1s9f" data-start="567" data-end="596">Premium Bamboo Cotton Blend</li> <li data-section-id="1tkfg7r" data-start="597" data-end="622">Breathable Mesh Comfort</li> <li data-section-id="6rds05" data-start="623" data-end="653">Moisture-Wicking Performance</li> <li data-section-id="eifvfa" data-start="654" data-end="681">Lightweight Athletic Feel</li> <li data-section-id="kh4r5p" data-start="682" data-end="708">Flexible Stretch Support</li> <li data-section-id="1pywbh2" data-start="709" data-end="738">Anti-Friction Comfort Zones</li> <li data-section-id="1yp8k4c" data-start="739" data-end="763">Secure Performance Fit</li> <li data-section-id="56gk69" data-start="764" data-end="797">Designed For Running &amp; Training</li></ul> <h5 data-section-id="1ma7m6t" data-start="1404" data-end="1419">Key Features</h5> <ul data-start="1421" data-end="1658"> <li data-section-id="kw2ptf" data-start="1421" data-end="1450">Premium bamboo cotton blend</li> <li data-section-id="16ctj8l" data-start="1451" data-end="1486">Breathable mesh ventilation zones</li> <li data-section-id="1x26q63" data-start="1487" data-end="1516">Moisture-wicking technology</li> <li data-section-id="gg02vw" data-start="1517" data-end="1549">Lightweight performance design</li> <li data-section-id="g7xnbs" data-start="1550" data-end="1577">Flexible athletic support</li> <li data-section-id="1bvcwu8" data-start="1578" data-end="1605">Anti-friction comfort fit</li> <li data-section-id="kkqb15" data-start="1606" data-end="1633">Secure movement stability</li> <li data-section-id="1u68fcc" data-start="1634" data-end="1658">Soft cushioned comfort</li></ul> <h3 data-section-id="1ip72t6" data-start="1665" data-end="1697">ADDITIONAL INFORMATION</h3> <h5 data-section-id="1ix3rke" data-start="1699" data-end="1710">Material</h5> <p data-start="1711" data-end="1738">Premium Bamboo Cotton Blend</p> <hr data-start="1740" data-end="1743" /> <h5 data-section-id="12fcay7" data-start="1745" data-end="1760">Suitable For</h5> <p data-start="1761" data-end="1818">Running, Gym, Training, Walking, Sports, Active Lifestyle</p> <hr data-start="1820" data-end="1823" /> <h5 data-section-id="26wt0m" data-start="1825" data-end="1836">Fit Type</h5> <p data-start="1837" data-end="1861">Flexible Performance Fit</p> <hr data-start="1863" data-end="1866" /> <h5 data-section-id="1hzu7ek" data-start="1868" data-end="1886">Fabric Benefits</h5> <p data-start="1887" data-end="1948">Breathable • Lightweight • Moisture Control • Stretch Comfort</p>',
                'categories' => [
                    0 => 'medical-socks',
                    1 => 'performance',
                ],
                'meta_title' => 'Performance Running Bamboo Socks | SOXNSOX',
                'meta_desc' => 'Designed with premium bamboo cotton and performance-focused support zones, SOX N SOX Performance Running Socks deliver breathable comfort, moisture control, and',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 6' => 399,
                ],
                'images' => [
                    0 => '1777096939245-019dc33a-f8d7-713b-a7f1-40cfdfb1335a.png',
                    1 => '1777097170162-019dc33e-849a-7742-8bfa-c292d87b8e2a.png',
                    2 => '1777097082979-019dc33d-1a91-707c-bda6-a80d5b28b6dd.png',
                    3 => '1777097016300-019dc33c-0dfa-7123-b8a5-ca6793e3bd0c.png',
                ],
                'variant_images' => [
                ],
            ],
            12 => [
                'sku' => 'soxnsox-school-comfort-socks',
                'name' => 'School Comfort Socks',
                'url_key' => 'school-comfort-socks',
                'short_desc' => 'Made with premium bamboo cotton, SOX N SOX School Comfort Socks are designed to provide soft breathable comfort, durability, and flexible support for everyday school wear. Perfect for long school hours, daily activities, walking, and active routines.',
                'description' => '<h3>Comfortable Support For Active School Days</h3> <h3 data-section-id="1a0jijh" data-start="433" data-end="462">Everyday School Comfort</h3> <p data-start="463" data-end="495">Soft • Breathable • Durable Wear</p> <h3 data-section-id="ejwits" data-start="792" data-end="836">Comfort Designed For Everyday School Life</h3> <p data-start="838" data-end="996">School Comfort Socks are thoughtfully designed for children who need breathable softness, flexible comfort, and reliable durability throughout the school day.</p> <p data-start="998" data-end="1154">Crafted using premium bamboo cotton fabric, these socks help keep feet fresh, dry, and comfortable during classes, sports, walking, and everyday activities.</p> <p data-start="1156" data-end="1292">Whether at school, during playtime, or on the move throughout the day, SOX N SOX delivers dependable comfort and softness in every step.</p> <h5 data-section-id="1dnykt1" data-start="502" data-end="516">KEY BENEFITS</h5> <ul data-start="518" data-end="758"> <li data-section-id="14wqo27" data-start="518" data-end="548">Premium Bamboo Cotton Fabric</li> <li data-section-id="12r5kgd" data-start="549" data-end="578">Soft Comfortable School Fit</li> <li data-section-id="fumlz2" data-start="579" data-end="608">Breathable Lightweight Feel</li> <li data-section-id="1o4etff" data-start="609" data-end="638">Moisture-Wicking Technology</li> <li data-section-id="kh4r5p" data-start="639" data-end="665">Flexible Stretch Support</li> <li data-section-id="1fjuhdi" data-start="666" data-end="692">Skin-Friendly Soft Touch</li> <li data-section-id="1h420al" data-start="693" data-end="724">Durable Everyday Construction</li> <li data-section-id="i02xkn" data-start="725" data-end="758">Designed For Active School Days</li></ul> <p>Key Features</p> <ul data-start="1340" data-end="1573"> <li data-section-id="kw2ptf" data-start="1340" data-end="1369">Premium bamboo cotton blend</li> <li data-section-id="1h4dd8u" data-start="1370" data-end="1398">Soft school comfort design</li> <li data-section-id="bjg4yx" data-start="1399" data-end="1430">Breathable lightweight fabric</li> <li data-section-id="1nibm1f" data-start="1431" data-end="1457">Moisture-wicking comfort</li> <li data-section-id="v577ul" data-start="1458" data-end="1484">Flexible stretch support</li> <li data-section-id="1xe9po" data-start="1485" data-end="1513">Skin-friendly soft texture</li> <li data-section-id="abw4ck" data-start="1514" data-end="1547">Durable daily wear construction</li> <li data-section-id="hbyqx3" data-start="1548" data-end="1573">Comfortable all-day fit</li></ul> <h3 data-section-id="1ip72t6" data-start="1580" data-end="1612">ADDITIONAL INFORMATION SECTION</h3> <h5 data-section-id="1ix3rke" data-start="1614" data-end="1625">Material</h5> <p data-start="1626" data-end="1653">Premium Bamboo Cotton Blend</p> <hr data-start="1655" data-end="1658" /> <h5 data-section-id="12fcay7" data-start="1660" data-end="1675">Suitable For</h5> <p data-start="1676" data-end="1745">School Wear, Daily Activities, Walking, Casual Wear, Everyday Comfort</p> <hr data-start="1747" data-end="1750" /> <h5 data-section-id="26wt0m" data-start="1752" data-end="1763">Fit Type</h5> <p data-start="1764" data-end="1791">Flexible School Comfort Fit</p> <hr data-start="1793" data-end="1796" /> <h5 data-section-id="1hzu7ek" data-start="1798" data-end="1816">Fabric Benefits</h5> <p data-start="1817" data-end="1863">Soft • Breathable • Durable • Moisture Control</p>',
                'categories' => [
                    0 => 'children',
                ],
                'meta_title' => 'School Comfort Socks | SOXNSOX',
                'meta_desc' => 'Made with premium bamboo cotton, SOX N SOX School Comfort Socks are designed to provide soft breathable comfort, durability, and flexible support for everyday s',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 249,
                    'Pack Of 6' => 399,
                ],
                'images' => [
                    0 => 'School-Comfort-Socks-for-kids.png',
                ],
                'variant_images' => [
                ],
            ],
            13 => [
                'sku' => 'soxnsox-travel-comfort-socks',
                'name' => 'Travel Comfort Bamboo Socks',
                'url_key' => 'travel-comfort-socks',
                'short_desc' => 'Crafted with premium bamboo cotton, SOX N SOX Travel Comfort Socks are designed to keep your feet soft, breathable, and comfortable during travel, long sitting hours, and everyday movement. The lightweight stretch fit and moisture-control fabric help reduce discomfort while keeping your feet fresh throughout the day.',
                'description' => '<h3 data-start="4592" data-end="4790">Soft Support For Every Journey</h3> <h3 data-section-id="1j8kiaa" data-start="496" data-end="531">Premium Bamboo Cotton Comfort</h3> <p data-start="532" data-end="575">Breathable • Soft • Everyday Travel Support</p> <h3 data-section-id="13xybto" data-start="860" data-end="897">Everyday Comfort For Every Journey</h3> <p data-start="899" data-end="1045">Travel Comfort Bamboo Socks are thoughtfully designed for people who spend long hours travelling, working, walking, or sitting throughout the day.</p> <p data-start="1047" data-end="1241">Made using premium bamboo cotton fabric, these socks provide breathable softness, moisture control, and flexible comfort to help your feet stay relaxed and refreshed wherever your day takes you.</p> <p data-start="1243" data-end="1420">Whether you’re travelling by flight, commuting daily, working long shifts, or simply looking for premium everyday comfort, SOX N SOX delivers softness and support in every step.</p> <h5 data-section-id="1ma7m6t" data-start="1451" data-end="1466">Key Features</h5> <ul data-start="1468" data-end="1732"> <li data-section-id="1gglg8f" data-start="1468" data-end="1498">Premium bamboo cotton fabric</li> <li data-section-id="1dfmgej" data-start="1499" data-end="1533">Soft breathable everyday comfort</li> <li data-section-id="hlikjp" data-start="1534" data-end="1564">Moisture-wicking performance</li> <li data-section-id="v577ul" data-start="1565" data-end="1591">Flexible stretch support</li> <li data-section-id="rxusmk" data-start="1592" data-end="1624">Lightweight feel for long wear</li> <li data-section-id="14zx43q" data-start="1625" data-end="1658">Skin-friendly soft-touch fabric</li> <li data-section-id="arm4lk" data-start="1659" data-end="1699">Comfortable fit for travel &amp; daily use</li> <li data-section-id="18cnsy9" data-start="1700" data-end="1732">Designed for all-day freshness</li></ul> <h5 data-section-id="1ma7m6t" data-start="1451" data-end="1466">Key Benefits</h5> <ul> <li data-section-id="1mt8gm7" data-start="489" data-end="512">Anti Odor Technology</li> <li data-section-id="1kb1acw" data-start="513" data-end="531">Moisture Wicking</li> <li data-section-id="2rd1a3" data-start="532" data-end="558">Breathable Bamboo Fabric</li> <li data-section-id="q5z10s" data-start="559" data-end="583">Soft Cushioned Comfort</li> <li data-section-id="1qxt5hl" data-start="584" data-end="611">Perfect for Long Journeys</li> <li data-section-id="ok3slw" data-start="612" data-end="631">Freshness All Day</li> <li data-section-id="65aw0q" data-start="632" data-end="657">Lightweight &amp; Quick Dry</li> <li data-section-id="1esticr" data-start="658" data-end="680">Seamless Toe Comfort</li></ul> <h3 data-section-id="1ip72t6" data-start="1739" data-end="1771">ADDITIONAL INFORMATION</h3> <h5 data-section-id="1ix3rke" data-start="1773" data-end="1784">Material</h5> <p data-start="1785" data-end="1812">Premium Bamboo Cotton Blend</p> <h5 data-section-id="12fcay7" data-start="1819" data-end="1834">Suitable For</h5> <p data-start="1835" data-end="1899">Travel, Office, Daily Wear, Long Sitting Hours, Everyday Comfort</p> <h5 data-section-id="26wt0m" data-start="1906" data-end="1917">Fit Type</h5> <p data-start="1918" data-end="1938">Flexible Comfort Fit</p> <h5 data-section-id="1hzu7ek" data-start="1945" data-end="1963">Fabric Benefits</h5> <p data-start="1964" data-end="2014">Breathable • Soft • Lightweight • Moisture Control</p>',
                'categories' => [
                    0 => 'everyday-comfort',
                    1 => 'medical-socks',
                ],
                'meta_title' => 'Travel Comfort Bamboo Socks | SOXNSOX',
                'meta_desc' => 'Crafted with premium bamboo cotton, SOX N SOX Travel Comfort Socks are designed to keep your feet soft, breathable, and comfortable during travel, long sitting ',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 349,
                    'Pack Of 6' => 599,
                ],
                'images' => [
                    0 => '7ab102a4-ebe3-474a-9536-d8975164135c-1.png',
                    1 => 'e1ac01ca-e47b-4234-b418-79248cb556a1.png',
                    2 => 'c1904d97-172f-4396-8700-df9b200d1af8.png',
                    3 => '278154cb-ca0d-45cd-8a4a-560ab1ba24fe.png',
                    4 => '93f54cbe-8c92-4ba6-80d0-b3eef00ae4eb.png',
                    5 => 'Travel-Comfort-Bamboo-Socks-All-colors-Black-Light-Grey-Navy-Blue-White-Pack-of-4-resized.png',
                    6 => 'Travel-Comfort-Bamboo-Socks-All-colors-Black-Light-Grey-Navy-Blue-White-Pack-of-12-resized.png',
                ],
                'variant_images' => [
                ],
            ],
            14 => [
                'sku' => 'soxnsox-yoga-grip-bamboo-socks',
                'name' => 'Yoga Grip Bamboo Socks',
                'url_key' => 'yoga-grip-bamboo-socks',
                'short_desc' => 'Designed with premium bamboo cotton and anti-slip grip technology, SOX N SOX Yoga Grip Bamboo Socks provide breathable comfort, flexible movement, and enhanced stability for yoga, pilates, stretching, workouts, and everyday relaxation. Move confidently with every step.',
                'description' => '<h3>Flexible Grip For Better Movement</h3> <h3 data-section-id="1ibkikx" data-start="445" data-end="472">Flexible Grip Comfort</h3> <p data-start="473" data-end="506">Stable • Breathable • Lightweight</p> <h3 data-section-id="2e9dn5" data-start="798" data-end="838">Stability &amp; Comfort In Every Movement</h3> <p data-start="840" data-end="990">Yoga Grip Bamboo Socks are specially designed for women who want secure grip, breathable comfort, and flexible support during movement and relaxation.</p> <p data-start="992" data-end="1190">Crafted using premium bamboo cotton fabric with durable anti-slip grip soles, these socks help improve traction and stability while keeping your feet soft, fresh, and comfortable throughout the day.</p> <p data-start="1192" data-end="1348">Whether you&#8217;re practicing yoga, Pilates, stretching, home workouts, or relaxing indoors, SOX N SOX delivers comfort, balance, and flexibility in every step.</p> <h5 data-section-id="1dnykt1" data-start="513" data-end="527">KEY BENEFITS</h5> <ul data-start="529" data-end="764"> <li data-section-id="1hc9z3v" data-start="529" data-end="556">Anti-Slip Grip Technology</li> <li data-section-id="14wqo27" data-start="557" data-end="587">Premium Bamboo Cotton Fabric</li> <li data-section-id="1c2qe56" data-start="588" data-end="620">Breathable Lightweight Comfort</li> <li data-section-id="1dy6ysx" data-start="621" data-end="648">Flexible Stretch Movement</li> <li data-section-id="cn4fkz" data-start="649" data-end="679">Enhanced Stability &amp; Balance</li> <li data-section-id="1nvueww" data-start="680" data-end="705">Moisture-Wicking Fabric</li> <li data-section-id="1j7ujuw" data-start="706" data-end="727">Soft Cushioned Feel</li> <li data-section-id="1u1f9p0" data-start="728" data-end="764">Designed For Yoga &amp; Active Comfort</li></ul> <h5 data-section-id="1ma7m6t" data-start="1379" data-end="1394">Key Features</h5> <ul data-start="1396" data-end="1639"> <li data-section-id="15036ku" data-start="1396" data-end="1428">Anti-slip grip sole technology</li> <li data-section-id="kw2ptf" data-start="1429" data-end="1458">Premium bamboo cotton blend</li> <li data-section-id="bjg4yx" data-start="1459" data-end="1490">Breathable lightweight fabric</li> <li data-section-id="gekqgs" data-start="1491" data-end="1517">Flexible stretch comfort</li> <li data-section-id="eagfst" data-start="1518" data-end="1549">Enhanced traction &amp; stability</li> <li data-section-id="hlikjp" data-start="1550" data-end="1580">Moisture-wicking performance</li> <li data-section-id="1u68fcc" data-start="1581" data-end="1605">Soft cushioned comfort</li> <li data-section-id="1nncpdk" data-start="1606" data-end="1639">Comfortable active movement fit</li></ul> <h3 data-section-id="1ip72t6" data-start="1646" data-end="1678">ADDITIONAL INFORMATION SECTION</h3> <h5 data-section-id="1ix3rke" data-start="1680" data-end="1691">Material</h5> <p data-start="1692" data-end="1719">Premium Bamboo Cotton Blend</p> <hr data-start="1721" data-end="1724" /> <h5 data-section-id="12fcay7" data-start="1726" data-end="1741">Suitable For</h5> <p data-start="1742" data-end="1819">Yoga, Pilates, Stretching, Indoor Workouts, Home Comfort, Everyday Relaxation</p> <hr data-start="1821" data-end="1824" /> <h5 data-section-id="26wt0m" data-start="1826" data-end="1837">Fit Type</h5> <p data-start="1838" data-end="1863">Flexible Grip Comfort Fit</p> <hr data-start="1865" data-end="1868" /> <h5 data-section-id="1hzu7ek" data-start="1870" data-end="1888">Fabric Benefits</h5> <p data-start="1889" data-end="1940">Breathable • Soft • Grip Support • Moisture Control</p>',
                'categories' => [
                    0 => 'women',
                ],
                'meta_title' => 'Yoga Grip Bamboo Socks | SOXNSOX',
                'meta_desc' => 'Designed with premium bamboo cotton and anti-slip grip technology, SOX N SOX Yoga Grip Bamboo Socks provide breathable comfort, flexible movement, and enhanced ',
                'new' => 1,
                'featured' => 0,
                'colors' => [
                    0 => 'All Colors',
                    1 => 'Black',
                    2 => 'Navy Blue',
                    3 => 'Sand Beige',
                    4 => 'White',
                ],
                'pack_sizes' => [
                    'Pack Of 4' => 249,
                    'Pack Of 6' => 399,
                ],
                'images' => [
                    0 => 'Yoga-Grip-Bamboo-Socks-for-women.png',
                ],
                'variant_images' => [
                ],
            ],
        ];

        // --------------------------------------------------------------------
        // 6. Insert Configurable Parents and Child Variants
        // --------------------------------------------------------------------
        $this->command->info('Creating configurable products and child variants...');
        $sourceDir = base_path('packages/Webkul/Installer/src/Resources/assets/images/seeders/soxnsox_products');

        foreach ($products as $pData) {
            $minPrice = min(array_values($pData['pack_sizes']));

            // 6a. Parent Configurable Product
            $parentId = DB::table('products')->insertGetId([
                'type' => 'configurable',
                'sku' => $pData['sku'],
                'attribute_family_id' => $attributeFamilyId,
                'parent_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('product_channels')->insert([
                'product_id' => $parentId,
                'channel_id' => $channelId,
            ]);

            DB::table('product_categories')->insert([
                'product_id' => $parentId,
                'category_id' => $rootId,
            ]);

            foreach ($pData['categories'] as $catSlug) {
                if (isset($categoryIds[$catSlug])) {
                    DB::table('product_categories')->insert([
                        'product_id' => $parentId,
                        'category_id' => $categoryIds[$catSlug],
                    ]);
                }
            }

            // Super Attributes: Color (23) and Pack Size ($packSizeAttrId)
            DB::table('product_super_attributes')->insert([
                ['product_id' => $parentId, 'attribute_id' => $colorAttrId],
                ['product_id' => $parentId, 'attribute_id' => $packSizeAttrId],
            ]);

            // Parent Product Attribute Values
            $parentAttrVals = [
                ['attribute_id' => 1, 'text_value' => $pData['sku']],
                ['attribute_id' => 2, 'text_value' => $pData['name']],
                ['attribute_id' => 3, 'text_value' => $pData['url_key']],
                ['attribute_id' => 9, 'text_value' => $pData['short_desc']],
                ['attribute_id' => 10, 'text_value' => $pData['description']],
                ['attribute_id' => 11, 'float_value' => $minPrice],
                ['attribute_id' => 16, 'text_value' => $pData['meta_title']],
                ['attribute_id' => 18, 'text_value' => $pData['meta_desc']],
                ['attribute_id' => 22, 'text_value' => '0.1'],
                ['attribute_id' => 5, 'boolean_value' => $pData['new']],
                ['attribute_id' => 6, 'boolean_value' => $pData['featured']],
                ['attribute_id' => 7, 'boolean_value' => 1], // visible_individually = 1
                ['attribute_id' => 8, 'boolean_value' => 1], // status = 1
                ['attribute_id' => 26, 'boolean_value' => 1], // guest_checkout = 1
            ];

            foreach ($parentAttrVals as $val) {
                $record = [
                    'product_id' => $parentId,
                    'attribute_id' => $val['attribute_id'],
                    'locale' => 'en',
                    'channel' => 'default',
                ];

                if (isset($val['text_value'])) {
                    $record['text_value'] = $val['text_value'];
                } elseif (isset($val['float_value'])) {
                    $record['float_value'] = $val['float_value'];
                } elseif (isset($val['boolean_value'])) {
                    $record['boolean_value'] = $val['boolean_value'];
                }

                $attr = DB::table('attributes')->where('id', $val['attribute_id'])->first();
                if ($attr) {
                    if (! $attr->value_per_locale) {
                        $record['locale'] = null;
                    }
                    if (! $attr->value_per_channel) {
                        $record['channel'] = null;
                    }
                }

                DB::table('product_attribute_values')->insert($record);
            }

            // Copy Parent Images (main + gallery images)
            $destDir = storage_path('app/public/products/'.$parentId);
            $pubDir = public_path('storage/products/'.$parentId);
            if (! file_exists($destDir)) {
                mkdir($destDir, 0777, true);
            }
            if (! file_exists($pubDir)) {
                mkdir($pubDir, 0777, true);
            }

            $rawHeroImage = null;
            $imgPos = 1;
            foreach ($pData['images'] as $imgFile) {
                $srcPath = $sourceDir.'/'.$imgFile;
                if (file_exists($srcPath)) {
                    copy($srcPath, $destDir.'/'.$imgFile);
                    copy($srcPath, $pubDir.'/'.$imgFile);

                    DB::table('product_images')->insert([
                        'path' => 'products/'.$parentId.'/'.$imgFile,
                        'product_id' => $parentId,
                        'position' => $imgPos++,
                    ]);

                    if ($rawHeroImage === null) {
                        $rawHeroImage = file_get_contents($srcPath);
                    }
                }
            }

            // 6b. Create Child Variants
            $variantCount = 0;
            foreach ($pData['colors'] as $colorName) {
                $colorOptionId = $colorOptionMap[$colorName] ?? $colorOptionMap[strtolower($colorName)] ?? $colorOptionMap[ucwords(strtolower($colorName))] ?? null;
                if (! $colorOptionId) {
                    continue;
                }

                $colorSlug = Str::slug($colorName);

                foreach ($pData['pack_sizes'] as $packName => $packPrice) {
                    $packOptionId = $packOptionMap[$packName] ?? $packOptionMap[strtolower($packName)] ?? $packOptionMap[ucwords(strtolower($packName))] ?? $packOptionMap[str_ireplace('of', 'Of', $packName)] ?? null;
                    if (! $packOptionId) {
                        continue;
                    }

                    $packSlug = Str::slug($packName);
                    $variantSku = "{$pData['sku']}-{$colorSlug}-{$packSlug}";
                    $variantName = "{$pData['name']} - {$colorName} - {$packName}";

                    $variantId = DB::table('products')->insertGetId([
                        'type' => 'simple',
                        'sku' => $variantSku,
                        'attribute_family_id' => $attributeFamilyId,
                        'parent_id' => $parentId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    // Link product_channels
                    DB::table('product_channels')->insert([
                        'product_id' => $variantId,
                        'channel_id' => $channelId,
                    ]);

                    // Variant Inventories
                    DB::table('product_inventories')->insert([
                        'qty' => 100,
                        'product_id' => $variantId,
                        'inventory_source_id' => $inventorySourceId,
                        'vendor_id' => 0,
                    ]);

                    // Variant Attribute Values
                    $varAttrVals = [
                        ['attribute_id' => 1, 'text_value' => $variantSku],
                        ['attribute_id' => 2, 'text_value' => $variantName],
                        ['attribute_id' => 3, 'text_value' => $variantSku],
                        ['attribute_id' => 11, 'float_value' => (float) $packPrice],
                        ['attribute_id' => 22, 'text_value' => '0.1'],
                        ['attribute_id' => 8, 'boolean_value' => 1], // status = 1
                        ['attribute_id' => 7, 'boolean_value' => 0], // visible_individually = 0
                        ['attribute_id' => 26, 'boolean_value' => 1], // guest_checkout = 1
                        ['attribute_id' => $colorAttrId, 'integer_value' => $colorOptionId],
                        ['attribute_id' => $packSizeAttrId, 'integer_value' => $packOptionId],
                    ];

                    foreach ($varAttrVals as $vVal) {
                        $vRecord = [
                            'product_id' => $variantId,
                            'attribute_id' => $vVal['attribute_id'],
                            'locale' => null,
                            'channel' => null,
                        ];

                        if (isset($vVal['text_value'])) {
                            $vRecord['text_value'] = $vVal['text_value'];
                        } elseif (isset($vVal['float_value'])) {
                            $vRecord['float_value'] = $vVal['float_value'];
                        } elseif (isset($vVal['boolean_value'])) {
                            $vRecord['boolean_value'] = $vVal['boolean_value'];
                        } elseif (isset($vVal['integer_value'])) {
                            $vRecord['integer_value'] = $vVal['integer_value'];
                        }

                        $vAttr = DB::table('attributes')->where('id', $vVal['attribute_id'])->first();
                        if ($vAttr) {
                            if ($vAttr->value_per_locale) {
                                $vRecord['locale'] = 'en';
                            }
                            if ($vAttr->value_per_channel) {
                                $vRecord['channel'] = 'default';
                            }
                        }

                        DB::table('product_attribute_values')->insert($vRecord);
                    }

                    // Attach Variant Image
                    $vDestDir = storage_path('app/public/products/'.$variantId);
                    $vPubDir = public_path('storage/products/'.$variantId);
                    if (! file_exists($vDestDir)) {
                        mkdir($vDestDir, 0777, true);
                    }
                    if (! file_exists($vPubDir)) {
                        mkdir($vPubDir, 0777, true);
                    }

                    // Check if dedicated live variant image exists
                    $comboKey = "{$colorSlug}_{$packSlug}";
                    $dedicatedImg = $pData['variant_images'][$comboKey] ?? null;

                    if ($dedicatedImg && file_exists($sourceDir.'/'.$dedicatedImg)) {
                        $vExt = pathinfo($dedicatedImg, PATHINFO_EXTENSION);
                        $vFileName = $variantSku.'.'.$vExt;
                        copy($sourceDir.'/'.$dedicatedImg, $vDestDir.'/'.$vFileName);
                        copy($sourceDir.'/'.$dedicatedImg, $vPubDir.'/'.$vFileName);

                        DB::table('product_images')->insert([
                            'path' => 'products/'.$variantId.'/'.$vFileName,
                            'product_id' => $variantId,
                            'position' => 1,
                        ]);
                    } elseif ($rawHeroImage) {
                        $vFileName = $variantSku.'.jpg';
                        $vTargetPath = $vDestDir.'/'.$vFileName;
                        $vPubPath = $vPubDir.'/'.$vFileName;

                        $this->generateVariantImage($rawHeroImage, $vTargetPath, $colorSlug, $packName);
                        if (file_exists($vTargetPath)) {
                            copy($vTargetPath, $vPubPath);

                            DB::table('product_images')->insert([
                                'path' => 'products/'.$variantId.'/'.$vFileName,
                                'product_id' => $variantId,
                                'position' => 1,
                            ]);
                        }
                    }

                    $variantCount++;
                }
            }

            $this->command->info("  Configured {$pData['name']}: {$variantCount} variants created.");
        }

        // --------------------------------------------------------------------
        // 6b. Link authentic related parent products (Never variants)
        // --------------------------------------------------------------------
        $this->command->info('Linking authentic related parent products...');
        $allParentIds = DB::table('products')->whereNull('parent_id')->pluck('id')->toArray();
        foreach ($allParentIds as $pId) {
            $otherParentIds = array_values(array_filter($allParentIds, fn ($id) => $id != $pId));
            shuffle($otherParentIds);
            $selectedRelated = array_slice($otherParentIds, 0, 4);
            foreach ($selectedRelated as $relId) {
                DB::table('product_relations')->insert([
                    'parent_id' => $pId,
                    'child_id' => $relId,
                ]);
            }
        }

        // --------------------------------------------------------------------
        // 7. Full Reindexing
        // --------------------------------------------------------------------
        $this->command->info('Running full product indexers...');
        app(Inventory::class)->reindexFull();
        app(Price::class)->reindexFull();
        app(Flat::class)->reindexFull();
        Artisan::call('indexer:index');
        Artisan::call('responsecache:clear');

        $this->command->info('=== SOXNSOX Configurable Catalog Seeder Complete ===');
    }

    /**
     * Generate a color-tinted and badged variant image.
     */
    private function generateVariantImage(string $raw, string $targetFile, string $colorSlug, string $packText): bool
    {
        if (! extension_loaded('gd')) {
            return false;
        }

        $src = @imagecreatefromstring($raw);
        if (! $src) {
            return false;
        }

        $w = imagesx($src);
        $h = imagesy($src);

        $dest = imagecreatetruecolor($w, $h);
        imagealphablending($dest, false);
        imagesavealpha($dest, true);

        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                $rgba = imagecolorat($src, $x, $y);
                $r = ($rgba >> 16) & 0xFF;
                $g = ($rgba >> 8) & 0xFF;
                $b = $rgba & 0xFF;
                $a = ($rgba >> 24) & 0x7F;

                // Clean white background
                if ($r > 248 && $g > 248 && $b > 248) {
                    imagesetpixel($dest, $x, $y, $rgba);

                    continue;
                }

                $lum = 0.299 * $r + 0.587 * $g + 0.114 * $b;

                // Floor shadow: strictly at bottom y > 1030, neutral grey lum > 195
                if ($y > 1030 && $lum > 195 && abs($r - $g) < 4 && abs($g - $b) < 4) {
                    imagesetpixel($dest, $x, $y, $rgba);

                    continue;
                }

                // Color transform
                if ($colorSlug === 'black') {
                    $factor = 0.32;
                    $newR = (int) ($r * $factor);
                    $newG = (int) ($g * $factor);
                    $newB = (int) ($b * $factor * 1.05);
                } elseif ($colorSlug === 'navy-blue') {
                    $newR = (int) (10 + $r * 0.12);
                    $newG = (int) (20 + $g * 0.22);
                    $newB = (int) (55 + $b * 0.52);
                } elseif ($colorSlug === 'sand-beige') {
                    $newR = (int) min(255, 120 + $r * 0.52);
                    $newG = (int) min(255, 100 + $g * 0.46);
                    $newB = (int) min(255, 75 + $b * 0.36);
                } elseif ($colorSlug === 'white') {
                    $boost = (255 - $lum) * 0.65;
                    $newR = (int) min(255, $r + $boost);
                    $newG = (int) min(255, $g + $boost);
                    $newB = (int) min(255, $b + $boost);
                } else {
                    $newR = $r;
                    $newG = $g;
                    $newB = $b;
                }

                // Anti-aliased edge smoothing
                if ($lum > 240) {
                    $blend = ($lum - 240) / 9.0;
                    $newR = (int) ($newR * (1 - $blend) + $r * $blend);
                    $newG = (int) ($newG * (1 - $blend) + $g * $blend);
                    $newB = (int) ($newB * (1 - $blend) + $b * $blend);
                }

                $newR = max(0, min(255, $newR));
                $newG = max(0, min(255, $newG));
                $newB = max(0, min(255, $newB));

                $pixel = imagecolorallocatealpha($dest, $newR, $newG, $newB, $a);
                imagesetpixel($dest, $x, $y, $pixel);
            }
        }

        // Draw Pack Badge in top-right
        if ($packText) {
            imagealphablending($dest, true);
            $bW = 260;
            $bH = 70;
            $bX = $w - $bW - 40;
            $bY = 40;
            $rad = 16;

            $shd = imagecolorallocatealpha($dest, 19, 59, 99, 105);
            imagefilledrectangle($dest, $bX + 3, $bY + 3, $bX + $bW + 3, $bY + $bH + 3, $shd);

            $navyBg = imagecolorallocate($dest, 19, 59, 99);
            $gold = imagecolorallocate($dest, 242, 154, 56);
            $white = imagecolorallocate($dest, 255, 255, 255);

            imagefilledrectangle($dest, $bX + $rad, $bY, $bX + $bW - $rad, $bY + $bH, $navyBg);
            imagefilledrectangle($dest, $bX, $bY + $rad, $bX + $bW, $bY + $bH - $rad, $navyBg);
            imagefilledellipse($dest, $bX + $rad, $bY + $rad, $rad * 2, $rad * 2, $navyBg);
            imagefilledellipse($dest, $bX + $bW - $rad, $bY + $rad, $rad * 2, $rad * 2, $navyBg);
            imagefilledellipse($dest, $bX + $rad, $bY + $bH - $rad, $rad * 2, $rad * 2, $navyBg);
            imagefilledellipse($dest, $bX + $bW - $rad, $bY + $bH - $rad, $rad * 2, $rad * 2, $navyBg);

            $stripeW = 6;
            imagefilledrectangle($dest, $bX + 2, $bY + $rad, $bX + $stripeW + 2, $bY + $bH - $rad, $gold);

            $fontPath = 'C:/Windows/Fonts/arialbd.ttf';
            if (file_exists($fontPath) && function_exists('imagettftext')) {
                imagettftext($dest, 9, 0, $bX + 22, $bY + 26, $gold, $fontPath, 'SOX N SOX');
                imagettftext($dest, 16, 0, $bX + 22, $bY + 52, $white, $fontPath, strtoupper($packText));
            } else {
                imagestring($dest, 5, $bX + 20, $bY + 25, strtoupper($packText), $white);
            }
        }

        imagejpeg($dest, $targetFile, 93);
        imagedestroy($src);
        imagedestroy($dest);

        return true;
    }
}
