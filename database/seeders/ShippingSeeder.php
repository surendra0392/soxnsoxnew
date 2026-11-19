<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        // 1. Zone 1: Andhra Pradesh & Telangana
        $zone1 = DB::table('shipping_zones')->where('name', 'Andhra & Telangana')->first();
        if (! $zone1) {
            $zone1Id = DB::table('shipping_zones')->insertGetId([
                'name' => 'Andhra & Telangana',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $zone1Id = $zone1->id;
            DB::table('shipping_zones')->where('id', $zone1Id)->update([
                'is_active' => 1,
                'updated_at' => $now,
            ]);
        }

        // Zone 1 Locations (AP, TG)
        foreach (['AP', 'TG'] as $locCode) {
            DB::table('shipping_zone_locations')->updateOrInsert(
                [
                    'shipping_zone_id' => $zone1Id,
                    'location_code' => $locCode,
                ],
                [
                    'location_type' => 'state',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // Zone 1 Methods: Flat Rate ₹60 & Free Shipping over ₹499
        DB::table('shipping_zone_methods')->updateOrInsert(
            [
                'shipping_zone_id' => $zone1Id,
                'type' => 'flat_rate',
            ],
            [
                'title' => 'Flat Rate',
                'is_active' => 1,
                'price' => 60.00,
                'min_weight' => 0.00,
                'max_weight' => 0.00,
                'min_subtotal' => 0.00,
                'max_subtotal' => 0.00,
                'priority' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('shipping_zone_methods')->updateOrInsert(
            [
                'shipping_zone_id' => $zone1Id,
                'type' => 'free_shipping',
            ],
            [
                'title' => 'Free Shipping (Over 499)',
                'is_active' => 1,
                'price' => 0.00,
                'min_weight' => 0.00,
                'max_weight' => 0.00,
                'min_subtotal' => 499.00,
                'max_subtotal' => 0.00,
                'priority' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // 2. Zone 2: Rest of India
        $zone2 = DB::table('shipping_zones')->where('name', 'Rest of India')->first();
        if (! $zone2) {
            $zone2Id = DB::table('shipping_zones')->insertGetId([
                'name' => 'Rest of India',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $zone2Id = $zone2->id;
            DB::table('shipping_zones')->where('id', $zone2Id)->update([
                'is_active' => 1,
                'updated_at' => $now,
            ]);
        }

        // Zone 2 Locations (IN)
        DB::table('shipping_zone_locations')->updateOrInsert(
            [
                'shipping_zone_id' => $zone2Id,
                'location_code' => 'IN',
            ],
            [
                'location_type' => 'country',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // Zone 2 Methods: Flat Rate ₹100 & Free Shipping over ₹499
        DB::table('shipping_zone_methods')->updateOrInsert(
            [
                'shipping_zone_id' => $zone2Id,
                'type' => 'flat_rate',
            ],
            [
                'title' => 'Flat Rate',
                'is_active' => 1,
                'price' => 100.00,
                'min_weight' => null,
                'max_weight' => null,
                'min_subtotal' => null,
                'max_subtotal' => null,
                'priority' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('shipping_zone_methods')->updateOrInsert(
            [
                'shipping_zone_id' => $zone2Id,
                'type' => 'free_shipping',
            ],
            [
                'title' => 'Free Shipping (Over 499)',
                'is_active' => 1,
                'price' => 0.00,
                'min_weight' => null,
                'max_weight' => null,
                'min_subtotal' => 499.00,
                'max_subtotal' => null,
                'priority' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
