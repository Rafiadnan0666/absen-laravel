<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status_hadir', ['present', 'late', 'absent'])->default('absent');
            $table->time('jam_kerja')->nullable();
            $table->time('jam_lembur')->nullable();
            $table->integer('menit_telat')->default(0);
            $table->integer('menit_pulang_cepat')->default(0);
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('face_verified')->default(false);
            $table->unique(['user_id', 'tanggal']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
