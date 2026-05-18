<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tanggal' => fake()->date(),
            'check_in' => fake()->time('H:i:s'),
            'check_out' => fake()->time('H:i:s'),
            'status_hadir' => fake()->randomElement(['present', 'late', 'absent']),
            'jam_kerja' => fake()->time('H:i:s'),
            'jam_lembur' => '00:00:00',
            'menit_telat' => fake()->numberBetween(0, 60),
            'menit_pulang_cepat' => fake()->numberBetween(0, 30),
            'face_verified' => fake()->boolean(),
        ];
    }
}
