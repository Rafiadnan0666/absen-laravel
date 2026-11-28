<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeds the reference/default data every installation needs:
 * roles, permissions, departments, job titles, shifts, locations,
 * salary rules and overtime rules.
 *
 * Safe to run multiple times - every seeder is idempotent.
 */
class DefaultDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            DepartmentSeeder::class,
            JobTitleSeeder::class,
            PermissionSeeder::class,
            ShiftSeeder::class,
            LocationSeeder::class,
            SalaryRuleSeeder::class,
            OvertimeRuleSeeder::class,
        ]);
    }
}
