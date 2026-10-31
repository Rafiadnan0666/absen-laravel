<?php

namespace Database\Factories;

use App\Models\Reimbursement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reimbursement>
 */
class ReimbursementFactory extends Factory
{
    protected $model = Reimbursement::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'kategori' => fake()->randomElement(['medical', 'transport', 'meals', 'office']),
            'jumlah' => fake()->numberBetween(50000, 2000000),
            'deskripsi' => fake()->sentence(8),
            'status' => 'pending',
            'approved_by' => null,
        ];
    }
}
