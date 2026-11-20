<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        Shift::updateOrCreate(
            ['nama_shift' => 'Regular'],
            [
                'jam_masuk' => '08:00',
                'jam_pulang' => '17:00',
                'toleransi_telat_menit' => 15,
                'is_default' => true,
            ]
        );
    }
}