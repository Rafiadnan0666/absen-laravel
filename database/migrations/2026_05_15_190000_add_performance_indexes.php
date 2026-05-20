<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasIndex('users', 'users_role_id_index'))
                $table->index('role_id');
            if (!Schema::hasIndex('users', 'users_department_id_index'))
                $table->index('department_id');
            if (!Schema::hasIndex('users', 'users_job_title_id_index'))
                $table->index('job_title_id');
            if (!Schema::hasIndex('users', 'users_status_akun_index'))
                $table->index('status_akun');
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasIndex('attendances', 'attendances_user_id_tanggal_index'))
                $table->index(['user_id', 'tanggal']);
        });

        Schema::table('leaves', function (Blueprint $table) {
            if (!Schema::hasIndex('leaves', 'leaves_user_id_index'))
                $table->index('user_id');
            if (!Schema::hasIndex('leaves', 'leaves_status_pengajuan_index'))
                $table->index('status_pengajuan');
            if (!Schema::hasIndex('leaves', 'leaves_tanggal_mulai_index'))
                $table->index('tanggal_mulai');
        });

        Schema::table('reimbursements', function (Blueprint $table) {
            if (!Schema::hasIndex('reimbursements', 'reimbursements_user_id_index'))
                $table->index('user_id');
            if (!Schema::hasIndex('reimbursements', 'reimbursements_status_index'))
                $table->index('status');
            if (Schema::hasColumn('reimbursements', 'kategori') && !Schema::hasIndex('reimbursements', 'reimbursements_kategori_index'))
                $table->index('kategori');
        });

        Schema::table('payrolls', function (Blueprint $table) {
            if (!Schema::hasIndex('payrolls', 'payrolls_user_id_index'))
                $table->index('user_id');
            if (!Schema::hasIndex('payrolls', 'payrolls_periode_mulai_index'))
                $table->index('periode_mulai');
            if (!Schema::hasIndex('payrolls', 'payrolls_user_id_periode_mulai_index'))
                $table->index(['user_id', 'periode_mulai']);
        });

        Schema::table('attendance_logs', function (Blueprint $table) {
            if (!Schema::hasIndex('attendance_logs', 'attendance_logs_user_id_index'))
                $table->index('user_id');
            if (!Schema::hasIndex('attendance_logs', 'attendance_logs_waktu_log_index'))
                $table->index('waktu_log');
            if (!Schema::hasIndex('attendance_logs', 'attendance_logs_tipe_log_index'))
                $table->index('tipe_log');
        });

        Schema::table('user_shifts', function (Blueprint $table) {
            if (!Schema::hasIndex('user_shifts', 'user_shifts_user_id_shift_id_tanggal_shift_index'))
                $table->index(['user_id', 'shift_id', 'tanggal_shift']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            if (Schema::hasColumn('announcements', 'dibuat_oleh') && !Schema::hasIndex('announcements', 'announcements_dibuat_oleh_index'))
                $table->index('dibuat_oleh');
            if (Schema::hasColumn('announcements', 'tanggal_mulai') && !Schema::hasIndex('announcements', 'announcements_tanggal_mulai_index'))
                $table->index('tanggal_mulai');
        });

        Schema::table('holidays', function (Blueprint $table) {
            if (!Schema::hasIndex('holidays', 'holidays_tanggal_index'))
                $table->index('tanggal');
        });

        Schema::table('locations', function (Blueprint $table) {
            if (Schema::hasColumn('locations', 'status') && !Schema::hasIndex('locations', 'locations_status_index'))
                $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_id_index');
            $table->dropIndex('users_department_id_index');
            $table->dropIndex('users_job_title_id_index');
            $table->dropIndex('users_status_akun_index');
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasIndex('attendances', 'attendances_user_id_tanggal_index'))
                $table->dropIndex('attendances_user_id_tanggal_index');
        });

        Schema::table('leaves', function (Blueprint $table) {
            if (Schema::hasIndex('leaves', 'leaves_user_id_index'))
                $table->dropIndex('leaves_user_id_index');
            if (Schema::hasIndex('leaves', 'leaves_status_pengajuan_index'))
                $table->dropIndex('leaves_status_pengajuan_index');
            if (Schema::hasIndex('leaves', 'leaves_tanggal_mulai_index'))
                $table->dropIndex('leaves_tanggal_mulai_index');
        });

        Schema::table('payrolls', function (Blueprint $table) {
            if (Schema::hasIndex('payrolls', 'payrolls_user_id_index'))
                $table->dropIndex('payrolls_user_id_index');
            if (Schema::hasIndex('payrolls', 'payrolls_periode_mulai_index'))
                $table->dropIndex('payrolls_periode_mulai_index');
            if (Schema::hasIndex('payrolls', 'payrolls_user_id_periode_mulai_index'))
                $table->dropIndex('payrolls_user_id_periode_mulai_index');
        });

        Schema::table('attendance_logs', function (Blueprint $table) {
            if (Schema::hasIndex('attendance_logs', 'attendance_logs_user_id_index'))
                $table->dropIndex('attendance_logs_user_id_index');
            if (Schema::hasIndex('attendance_logs', 'attendance_logs_waktu_log_index'))
                $table->dropIndex('attendance_logs_waktu_log_index');
            if (Schema::hasIndex('attendance_logs', 'attendance_logs_tipe_log_index'))
                $table->dropIndex('attendance_logs_tipe_log_index');
        });

        Schema::table('user_shifts', function (Blueprint $table) {
            if (Schema::hasIndex('user_shifts', 'user_shifts_user_id_shift_id_tanggal_shift_index'))
                $table->dropIndex('user_shifts_user_id_shift_id_tanggal_shift_index');
        });

        Schema::table('reimbursements', function (Blueprint $table) {
            if (Schema::hasIndex('reimbursements', 'reimbursements_user_id_index'))
                $table->dropIndex('reimbursements_user_id_index');
            if (Schema::hasIndex('reimbursements', 'reimbursements_status_index'))
                $table->dropIndex('reimbursements_status_index');
            if (Schema::hasIndex('reimbursements', 'reimbursements_kategori_index'))
                $table->dropIndex('reimbursements_kategori_index');
        });

        Schema::table('announcements', function (Blueprint $table) {
            if (Schema::hasIndex('announcements', 'announcements_dibuat_oleh_index'))
                $table->dropIndex('announcements_dibuat_oleh_index');
            if (Schema::hasIndex('announcements', 'announcements_tanggal_mulai_index'))
                $table->dropIndex('announcements_tanggal_mulai_index');
        });

        Schema::table('holidays', function (Blueprint $table) {
            if (Schema::hasIndex('holidays', 'holidays_tanggal_index'))
                $table->dropIndex('holidays_tanggal_index');
        });

        Schema::table('locations', function (Blueprint $table) {
            if (Schema::hasIndex('locations', 'locations_status_index'))
                $table->dropIndex('locations_status_index');
        });
    }
};
