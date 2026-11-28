<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('salary_rules', function (Blueprint $table) {
            $table->decimal('gaji_per_hari', 15, 2)->nullable()->after('rate_lembur');
            $table->decimal('gaji_per_jam', 15, 2)->nullable()->after('gaji_per_hari');
            $table->decimal('penalti_alfa_per_hari', 15, 2)->default(0)->after('penalti_tidak_hadir');
            $table->decimal('penalti_pulang_cepat_per_menit', 15, 2)->default(0)->after('penalti_alfa_per_hari');
        });
    }

    public function down(): void
    {
        Schema::table('salary_rules', function (Blueprint $table) {
            $table->dropColumn([
                'gaji_per_hari',
                'gaji_per_jam',
                'penalti_alfa_per_hari',
                'penalti_pulang_cepat_per_menit',
            ]);
        });
    }
};