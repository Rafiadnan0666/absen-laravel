<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
            $table->index('role_id');
            $table->index('department_id');
            $table->index('job_title_id');
            $table->index('status_akun');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('tanggal');
            $table->index(['user_id', 'tanggal']);
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
            $table->index('tanggal_mulai');
        });

        Schema::table('reimbursements', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
            $table->index('kategori');
        });

        Schema::table('payrolls', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('bulan');
            $table->index('tahun');
            $table->index(['user_id', 'bulan', 'tahun']);
        });

        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('waktu');
            $table->index('jenis');
        });

        Schema::table('user_shifts', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('shift_id');
            $table->index('tanggal');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->index('status');
            $table->index('tanggal_mulai');
        });

        Schema::table('holidays', function (Blueprint $table) {
            $table->index('tanggal');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('face_logs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('waktu');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email', 'role_id', 'department_id', 'job_title_id', 'status_akun']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'tanggal', 'user_id_tanggal']);
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status', 'tanggal_mulai']);
        });

        Schema::table('reimbursements', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status', 'kategori']);
        });

        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'bulan', 'tahun', 'user_id_bulan_tahun']);
        });

        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'waktu', 'jenis']);
        });

        Schema::table('user_shifts', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'shift_id', 'tanggal']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex(['status', 'tanggal_mulai']);
        });

        Schema::table('holidays', function (Blueprint $table) {
            $table->dropIndex(['tanggal']);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('face_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'waktu']);
        });
    }
};