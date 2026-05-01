<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nama_role' => 'admin'],
            ['nama_role' => 'hr'],
            ['nama_role' => 'employee'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
