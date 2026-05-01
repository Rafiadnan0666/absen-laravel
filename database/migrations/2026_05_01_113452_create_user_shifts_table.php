<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shift_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_shift');
            $table->unique(['user_id', 'tanggal_shift']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_shifts');
    }
};
