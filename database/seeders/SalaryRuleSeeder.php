<?php

namespace Database\Seeders;

use App\Models\SalaryRule;
use Illuminate\Database\Seeder;

class SalaryRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            [
                'tipe_gaji' => 'monthly',
                'rate_lembur' => 50000,
                'gaji_per_hari' => null,
                'gaji_per_jam' => null,
                'penalti_telat_per_menit' => 1000,
                'penalti_tidak_hadir' => 150000,
                'penalti_alfa_per_hari' => 150000,
                'penalti_pulang_cepat_per_menit' => 500,
            ],
            [
                'tipe_gaji' => 'daily',
                'rate_lembur' => 25000,
                'gaji_per_hari' => 300000,
                'gaji_per_jam' => null,
                'penalti_telat_per_menit' => 500,
                'penalti_tidak_hadir' => 300000,
                'penalti_alfa_per_hari' => 300000,
                'penalti_pulang_cepat_per_menit' => 250,
            ],
            [
                'tipe_gaji' => 'hourly',
                'rate_lembur' => 20000,
                'gaji_per_hari' => null,
                'gaji_per_jam' => 40000,
                'penalti_telat_per_menit' => 250,
                'penalti_tidak_hadir' => 200000,
                'penalti_alfa_per_hari' => 200000,
                'penalti_pulang_cepat_per_menit' => 100,
            ],
        ];

        foreach ($rules as $rule) {
            SalaryRule::updateOrCreate(
                ['tipe_gaji' => $rule['tipe_gaji']],
                $rule
            );
        }
    }
}
