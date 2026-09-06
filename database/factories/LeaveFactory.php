<?php

namespace Database\Factories;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Leave>
 */
class LeaveFactory extends Factory
{
    protected $model = Leave::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('now', '+10 days');
        $end = (clone $start)->modify('+2 days');

        return [
            'user_id' => User::factory(),
            'tipe_cuti' => fake()->randomElement(['sick', 'annual', 'unpaid']),
            'tanggal_mulai' => $start->format('Y-m-d'),
            'tanggal_selesai' => $end->format('Y-m-d'),
            'alasan' => fake()->sentence(8),
            'status_pengajuan' => 'pending',
            'approved_by' => null,
        ];
    }
}
