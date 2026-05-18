<?php

namespace Database\Factories;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveFactory extends Factory
{
    protected $model = Leave::class;

    public function definition(): array
    {
        $start = fake()->date();
        $end = fake()->dateTimeBetween($start, '+7 days')->format('Y-m-d');

        return [
            'user_id' => User::factory(),
            'tipe_cuti' => fake()->randomElement(['sick', 'annual', 'unpaid']),
            'tanggal_mulai' => $start,
            'tanggal_selesai' => $end,
            'alasan' => fake()->sentence(),
            'status_pengajuan' => fake()->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
