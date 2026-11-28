<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Role;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserShift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Development-only seeder with default credentials.
 * Only runs when APP_ENV=local or APP_ENV=development.
 */
class DevUserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (! $this->shouldRun()) {
            $this->command?->info('Skipping DevUserSeeder: not in development environment');

            return;
        }

        $adminRole = Role::where('nama_role', 'admin')->first();
        $hrRole = Role::where('nama_role', 'hr')->first();
        $employeeRole = Role::where('nama_role', 'employee')->first();

        if (! $adminRole || ! $hrRole || ! $employeeRole) {
            $this->command?->warn('Skipping DevUserSeeder: roles have not been seeded yet.');

            return;
        }

        $department = Department::where('nama_department', 'Information Technology')->first()
            ?? Department::first();
        $jobTitle = JobTitle::where('nama_jabatan', 'Software Engineer')->first()
            ?? JobTitle::first();

        if (! $department || ! $jobTitle) {
            $this->command?->warn('Skipping DevUserSeeder: departments/job titles have not been seeded yet.');

            return;
        }

        $users = [
            [
                'email' => 'admin@example.com',
                'nama_lengkap' => 'Administrator',
                'no_hp' => '081234567890',
                'role_id' => $adminRole->id,
                'jumlah_gaji' => 15000000,
                'tanggal_masuk' => today()->subYears(2),
            ],
            [
                'email' => 'hr@example.com',
                'nama_lengkap' => 'HR Manager',
                'no_hp' => '081234567891',
                'role_id' => $hrRole->id,
                'jumlah_gaji' => 12000000,
                'tanggal_masuk' => today()->subYears(1),
            ],
            [
                'email' => 'employee@example.com',
                'nama_lengkap' => 'John Doe',
                'no_hp' => '081234567892',
                'role_id' => $employeeRole->id,
                'jumlah_gaji' => 8000000,
                'tanggal_masuk' => today()->subMonths(6),
            ],
        ];

        $defaultShift = Shift::defaultShift();

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'nama_lengkap' => $data['nama_lengkap'],
                    'password' => Hash::make('password'),
                    'no_hp' => $data['no_hp'],
                    'alamat' => 'Jakarta, Indonesia',
                    'job_title_id' => $jobTitle->id,
                    'department_id' => $department->id,
                    'role_id' => $data['role_id'],
                    'tipe_gaji' => 'monthly',
                    'jumlah_gaji' => $data['jumlah_gaji'],
                    'tanggal_masuk' => $data['tanggal_masuk'],
                    'status_akun' => 'active',
                ]
            );

            if ($defaultShift) {
                UserShift::firstOrCreate([
                    'user_id' => $user->id,
                    'shift_id' => $defaultShift->id,
                    'tanggal_shift' => today(),
                ]);
            }
        }
    }

    private function shouldRun(): bool
    {
        return app()->environment(['local', 'development']);
    }
}
