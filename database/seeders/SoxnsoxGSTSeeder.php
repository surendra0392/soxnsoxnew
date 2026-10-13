<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoxnsoxGSTSeeder extends Seeder
{
    /**
     * Seed 37 Indian State/UT GST 5% Tax Rates.
     */
    public function run(): void
    {
        $this->command->info('=== Seeding SOXNSOX GST Tax Rates ===');

        $now = Carbon::now();

        $states = [
            '' => 'GST_',
            'AN' => 'GST_AN',
            'AP' => 'GST_AP',
            'AR' => 'GST_AR',
            'AS' => 'GST_AS',
            'BR' => 'GST_BR',
            'CH' => 'GST_CH',
            'CT' => 'GST_CT',
            'DH' => 'GST_DH',
            'DD' => 'GST_DD',
            'DL' => 'GST_DL',
            'GA' => 'GST_GA',
            'GJ' => 'GST_GJ',
            'HR' => 'GST_HR',
            'HP' => 'GST_HP',
            'JK' => 'GST_JK',
            'JH' => 'GST_JH',
            'KA' => 'GST_KA',
            'KL' => 'GST_KL',
            'LD' => 'GST_LD',
            'MP' => 'GST_MP',
            'MH' => 'GST_MH',
            'MN' => 'GST_MN',
            'ML' => 'GST_ML',
            'MZ' => 'GST_MZ',
            'NL' => 'GST_NL',
            'OR' => 'GST_OR',
            'PY' => 'GST_PY',
            'PB' => 'GST_PB',
            'RJ' => 'GST_RJ',
            'SK' => 'GST_SK',
            'TN' => 'GST_TN',
            'TG' => 'GST_TG',
            'TR' => 'GST_TR',
            'UP' => 'GST_UP',
            'UT' => 'GST_UT',
            'WB' => 'GST_WB',
        ];

        foreach ($states as $stateCode => $identifier) {
            DB::table('tax_rates')->updateOrInsert(
                [
                    'identifier' => $identifier,
                    'country' => 'IN',
                    'state' => $stateCode,
                ],
                [
                    'is_zip' => 0,
                    'zip_code' => '',
                    'zip_from' => null,
                    'zip_to' => null,
                    'tax_rate' => 5.0000,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $this->command->info('37 GST Tax Rates Seeded Successfully.');
    }
}
