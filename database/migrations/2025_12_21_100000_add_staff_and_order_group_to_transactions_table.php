<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Nhân viên đặt món
            $table->foreignId('staff_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
            
            // Group orders cùng bàn, cùng thời gian (để quản lý nhiều đơn trong 1 bàn)
            $table->string('order_group_id')->nullable()->after('table_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropColumn(['staff_id', 'order_group_id']);
        });
    }
};

