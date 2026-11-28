<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::updateOrCreate(
            ['nama_lokasi' => 'Kantor Pusat'],
            [
                'nama_lokasi' => 'Kantor Pusat',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'radius_meter' => 100,
            ]
        );
    }
}
