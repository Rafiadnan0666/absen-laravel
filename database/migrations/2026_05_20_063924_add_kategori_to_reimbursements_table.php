<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('reimbursements', 'kategori')) {
            Schema::table('reimbursements', function (Blueprint $table) {
                $table->string('kategori')->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('reimbursements', 'kategori')) {
            Schema::table('reimbursements', function (Blueprint $table) {
                $table->dropColumn('kategori');
            });
        }
    }
};
