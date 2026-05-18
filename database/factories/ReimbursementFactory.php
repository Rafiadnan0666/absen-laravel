<?php

namespace Database\Factories;

use App\Models\Reimbursement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReimbursementFactory extends Factory
{
    protected $model = Reimbursement::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'kategori' => fake()->randomElement(['transport', 'medical', 'education', 'other']),
            'jumlah' => fake()->numberBetween(50000, 5000000),
            'deskripsi' => fake()->sentence(),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
