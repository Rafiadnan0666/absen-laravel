<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['nama_department' => 'Human Resources', 'deskripsi' => 'HR Department'],
            ['nama_department' => 'Information Technology', 'deskripsi' => 'IT Department'],
            ['nama_department' => 'Finance', 'deskripsi' => 'Finance Department'],
            ['nama_department' => 'Operations', 'deskripsi' => 'Operations Department'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
