<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Seed the default reference data (roles, permissions, departments,
     * job titles, shifts, office location, salary rules, overtime rules)
     * so a fresh `php artisan migrate` produces a working database.
     *
     * The seeders are idempotent, so running `db:seed` afterwards is safe.
     */
    public function up(): void
    {
        Artisan::call('db:seed', [
            '--class' => \Database\Seeders\DatabaseSeeder::class,
            '--force' => true,
        ]);
    }

    public function down(): void
    {
        // Reference data is intentionally left in place: user records may
        // reference these rows. Remove it manually if a full reset is needed.
    }
};
