<?php

namespace Database\Seeders;

use App\Models\OvertimeRule;
use Illuminate\Database\Seeder;

class OvertimeRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            ['minimal_jam' => 1.00, 'multiplier' => 1.50],
            ['minimal_jam' => 2.00, 'multiplier' => 2.00],
        ];

        foreach ($rules as $rule) {
            OvertimeRule::updateOrCreate(
                ['minimal_jam' => $rule['minimal_jam']],
                $rule
            );
        }
    }
}
