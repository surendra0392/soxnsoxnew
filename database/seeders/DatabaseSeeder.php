<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Installer\Database\Seeders\DatabaseSeeder as BagistoDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Run Base Bagisto Core Architecture & System Seeders
        $this->call(BagistoDatabaseSeeder::class);

        // 2. Run SOX N SOX Storefront Configuration & Content Seeders
        $this->call(SoxnsoxConfigSeeder::class);
        $this->call(SoxnsoxGSTSeeder::class);
        $this->call(ShippingSeeder::class);
        $this->call(SoxnsoxCatalogSeeder::class);
        $this->call(SoxnsoxPromotionSeeder::class);
        $this->call(SoxnsoxHeroSliderSeeder::class);
        $this->call(SoxnsoxCMSSeeder::class);
        $this->call(SoxnsoxMenuSeeder::class);
        $this->call(SoxnsoxThemeCustomizationSeeder::class);
        $this->call(SoxnsoxBlogSeeder::class);
        $this->call(SoxnsoxSEOSeeder::class);
    }
}
