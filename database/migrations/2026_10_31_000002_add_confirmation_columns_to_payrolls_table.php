<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('status_pembayaran');
            $table->timestamp('confirmed_at')->nullable()->after('confirmed_by');
            $table->timestamp('paid_at')->nullable()->after('confirmed_at');
            $table->string('rejection_reason')->nullable()->after('paid_at');

            $table->index('confirmed_by');
        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropIndex(['confirmed_by']);
            $table->dropColumn(['confirmed_by', 'confirmed_at', 'paid_at', 'rejection_reason']);
        });
    }
};
