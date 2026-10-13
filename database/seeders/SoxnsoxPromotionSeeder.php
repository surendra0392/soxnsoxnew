<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoxnsoxPromotionSeeder extends Seeder
{
    /**
     * Seed SOXNSOX Cart Rules & Promotions (SOXNSOX10 - 10% Off).
     */
    public function run(): void
    {
        $this->command->info('=== Seeding SOXNSOX Cart Rules & Promotions ===');

        $now = Carbon::now();

        // 1. Create or Update SOXNSOX10 Cart Rule
        $rule = DB::table('cart_rules')->where('name', 'SOXNSOX10')->first();

        $ruleData = [
            'name' => 'SOXNSOX10',
            'description' => '10% discount on all bamboo and diabetic socks',
            'starts_from' => null,
            'ends_till' => null,
            'status' => 1,
            'coupon_type' => 1,
            'use_auto_generation' => 0,
            'usage_per_customer' => 1,
            'uses_per_coupon' => 100,
            'times_used' => 0,
            'condition_type' => 1,
            'conditions' => null,
            'end_other_rules' => 0,
            'uses_attribute_conditions' => 0,
            'action_type' => 'by_percent',
            'discount_amount' => 10.0000,
            'discount_quantity' => 0,
            'discount_step' => 0,
            'apply_to_shipping' => 0,
            'free_shipping' => 0,
            'sort_order' => 0,
            'first_order_only' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        if (! $rule) {
            $ruleId = DB::table('cart_rules')->insertGetId($ruleData);
        } else {
            $ruleId = $rule->id;
            DB::table('cart_rules')->where('id', $ruleId)->update($ruleData);
        }

        // 2. Attach Coupon Code 'SOXNSOX10'
        DB::table('cart_rule_coupons')->updateOrInsert(
            [
                'cart_rule_id' => $ruleId,
                'code' => 'SOXNSOX10',
            ],
            [
                'usage_limit' => 100,
                'usage_per_customer' => 1,
                'times_used' => 0,
                'type' => 0,
                'is_primary' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // 3. Link Cart Rule to Channel 1 (Default)
        DB::table('cart_rule_channels')->updateOrInsert(
            [
                'cart_rule_id' => $ruleId,
                'channel_id' => 1,
            ]
        );

        // 4. Link Cart Rule to All Customer Groups
        $customerGroups = DB::table('customer_groups')->pluck('id');
        foreach ($customerGroups as $groupId) {
            DB::table('cart_rule_customer_groups')->updateOrInsert(
                [
                    'cart_rule_id' => $ruleId,
                    'customer_group_id' => $groupId,
                ]
            );
        }

        $this->command->info('SOXNSOX10 Cart Rule & Coupon Seeded Successfully.');
    }
}
