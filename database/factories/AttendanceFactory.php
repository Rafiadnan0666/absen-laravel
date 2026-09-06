<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $checkIn = fake()->time('H:i:s', '08:30:00');
        $checkOut = fake()->time('H:i:s', '17:30:00');

        return [
            'user_id' => User::factory(),
            'tanggal' => fake()->dateTimeBetween('-1 month', '+1 week')->format('Y-m-d'),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status_hadir' => fake()->randomElement(['present', 'late', 'absent']),
            'jam_kerja' => '08:00:00',
            'jam_lembur' => null,
            'menit_telat' => 0,
            'menit_pulang_cepat' => 0,
            'location_id' => null,
            'face_verified' => false,
        ];
    }
}
