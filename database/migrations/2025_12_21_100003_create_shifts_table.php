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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên ca: "Ca sáng", "Ca chiều", "Ca tối"
            $table->time('start_time'); // Giờ bắt đầu: 06:00:00
            $table->time('end_time'); // Giờ kết thúc: 14:00:00
            $table->text('description')->nullable(); // Mô tả ca làm việc
            $table->boolean('is_active')->default(true); // Ca có đang hoạt động không
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};

