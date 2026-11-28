<?php

namespace Database\Factories;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payroll>
 */
class PayrollFactory extends Factory
{
    protected $model = Payroll::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'periode_mulai' => now()->startOfMonth()->toDateString(),
            'periode_selesai' => now()->endOfMonth()->toDateString(),
            'gaji_pokok' => 5000000,
            'total_lembur' => 0,
            'total_potongan' => 0,
            'bonus' => 0,
            'total_gaji' => 5000000,
            'status_pembayaran' => 'pending',
        ];
    }
}