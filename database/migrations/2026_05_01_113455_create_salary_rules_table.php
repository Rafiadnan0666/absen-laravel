<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_gaji', ['hourly', 'daily', 'monthly']);
            $table->decimal('rate_lembur', 15, 2);
            $table->decimal('penalti_telat_per_menit', 15, 2)->default(0);
            $table->decimal('penalti_tidak_hadir', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_rules');
    }
};
