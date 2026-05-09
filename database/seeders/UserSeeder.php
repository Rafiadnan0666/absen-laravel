<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = \App\Models\Role::where('nama_role', 'admin')->first();
        $hrRole = \App\Models\Role::where('nama_role', 'hr')->first();
        $employeeRole = \App\Models\Role::where('nama_role', 'employee')->first();

        // Create admin user
        User::create([
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'alamat' => 'Jakarta, Indonesia',
            'job_title_id' => 1, // Will need to ensure this exists
            'department_id' => 1, // Will need to ensure this exists
            'role_id' => $adminRole->id,
            'tipe_gaji' => 'monthly',
            'jumlah_gaji' => 15000000,
            'tanggal_masuk' => today()->subYears(2),
            'status_akun' => 'active',
        ]);

        // Create HR user
        User::create([
            'nama_lengkap' => 'HR Manager',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567891',
            'alamat' => 'Jakarta, Indonesia',
            'job_title_id' => 1,
            'department_id' => 1,
            'role_id' => $hrRole->id,
            'tipe_gaji' => 'monthly',
            'jumlah_gaji' => 12000000,
            'tanggal_masuk' => today()->subYears(1),
            'status_akun' => 'active',
        ]);

        // Create employee user
        User::create([
            'nama_lengkap' => 'John Doe',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567892',
            'alamat' => 'Jakarta, Indonesia',
            'job_title_id' => 1,
            'department_id' => 1,
            'role_id' => $employeeRole->id,
            'tipe_gaji' => 'monthly',
            'jumlah_gaji' => 8000000,
            'tanggal_masuk' => today()->subMonths(6),
            'status_akun' => 'active',
        ]);
    }
}