<?php

namespace Database\Factories;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollFactory extends Factory
{
    protected $model = Payroll::class;

    public function definition(): array
    {
        $gajiPokok = fake()->numberBetween(3000000, 15000000);

        return [
            'user_id' => User::factory(),
            'periode_mulai' => fake()->date(),
            'periode_selesai' => fake()->date(),
            'gaji_pokok' => $gajiPokok,
            'total_lembur' => fake()->numberBetween(0, 1000000),
            'total_potongan' => fake()->numberBetween(0, 500000),
            'bonus' => fake()->numberBetween(0, 500000),
            'total_gaji' => $gajiPokok,
            'status_pembayaran' => fake()->randomElement(['pending', 'paid']),
        ];
    }
}
