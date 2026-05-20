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
            $table->index(['user_id', 'tanggal']);
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status_pengajuan');
            $table->index('tanggal_mulai');
        });

        Schema::table('reimbursements', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
            $table->index('kategori');
        });

        Schema::table('payrolls', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('periode_mulai');
            $table->index(['user_id', 'periode_mulai']);
        });

        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('waktu_log');
            $table->index('tipe_log');
        });

        Schema::table('user_shifts', function (Blueprint $table) {
            $table->index(['user_id', 'shift_id', 'tanggal_shift']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->index('dibuat_oleh');
            $table->index('tanggal_mulai');
        });

        Schema::table('holidays', function (Blueprint $table) {
            $table->index('tanggal');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email', 'role_id', 'department_id', 'job_title_id', 'status_akun']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['user_id_tanggal']);
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status_pengajuan', 'tanggal_mulai']);
        });

        Schema::table('reimbursements', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status', 'kategori']);
        });

        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'periode_mulai', 'user_id_periode_mulai']);
        });

        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'waktu_log', 'tipe_log']);
        });

        Schema::table('user_shifts', function (Blueprint $table) {
            $table->dropIndex(['user_id_shift_id_tanggal_shift']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex(['dibuat_oleh', 'tanggal_mulai']);
        });

        Schema::table('holidays', function (Blueprint $table) {
            $table->dropIndex(['tanggal']);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
