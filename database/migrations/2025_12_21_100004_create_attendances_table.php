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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Nhân viên
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->onDelete('set null'); // Ca làm việc
            $table->date('work_date'); // Ngày làm việc
            $table->timestamp('check_in')->nullable(); // Giờ check-in
            $table->timestamp('check_out')->nullable(); // Giờ check-out
            $table->integer('check_in_late_minutes')->default(0); // Số phút đi muộn (âm = đi sớm)
            $table->integer('check_out_early_minutes')->default(0); // Số phút về sớm (âm = về muộn)
            $table->enum('status', ['present', 'absent', 'late', 'early_leave'])->default('present');
            // present: Có mặt, absent: Vắng mặt, late: Đi muộn, early_leave: Về sớm
            $table->text('notes')->nullable(); // Ghi chú
            $table->timestamps();
            
            $table->index(['user_id', 'work_date']);
            $table->index('work_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

