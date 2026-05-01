<?php

namespace Database\Seeders;

use App\Models\JobTitle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    public function run(): void
    {
        $jobTitles = [
            ['nama_jabatan' => 'Software Engineer', 'deskripsi' => 'Develops software applications', 'default_gaji' => 8000000],
            ['nama_jabatan' => 'HR Manager', 'deskripsi' => 'Manages HR operations', 'default_gaji' => 10000000],
            ['nama_jabatan' => 'Finance Analyst', 'deskripsi' => 'Analyzes financial data', 'default_gaji' => 7000000],
            ['nama_jabatan' => 'Operations Staff', 'deskripsi' => 'Handles daily operations', 'default_gaji' => 5000000],
            ['nama_jabatan' => 'Admin', 'deskripsi' => 'System administrator', 'default_gaji' => 12000000],
        ];

        foreach ($jobTitles as $job) {
            JobTitle::create($job);
        }
    }
}
