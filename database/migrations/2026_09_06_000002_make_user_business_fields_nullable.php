<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->timestamp('email_verified_at')->nullable()->change();
            $table->foreignId('job_title_id')->nullable()->change();
            $table->foreignId('department_id')->nullable()->change();
            $table->foreignId('role_id')->nullable()->change();
            $table->enum('tipe_gaji', ['hourly', 'daily', 'monthly'])->nullable()->change();
            $table->decimal('jumlah_gaji', 15, 2)->nullable()->change();
            $table->date('tanggal_masuk')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->timestamp('email_verified_at')->nullable(false)->change();
            $table->foreignId('job_title_id')->nullable(false)->change();
            $table->foreignId('department_id')->nullable(false)->change();
            $table->foreignId('role_id')->nullable(false)->change();
            $table->enum('tipe_gaji', ['hourly', 'daily', 'monthly'])->nullable(false)->change();
            $table->decimal('jumlah_gaji', 15, 2)->nullable(false)->change();
            $table->date('tanggal_masuk')->nullable(false)->change();
        });
    }
};
