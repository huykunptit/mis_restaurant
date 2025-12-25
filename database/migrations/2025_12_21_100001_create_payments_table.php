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
        // Kiểm tra xem bảng payments đã tồn tại chưa
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('table_id')->nullable()->constrained('tables')->onDelete('set null');
                $table->string('order_group_id')->nullable()->index(); // Group các orders cùng bàn
                $table->enum('payment_method', ['sepay_qr', 'vnpay_qr', 'bank_transfer', 'cash'])->default('cash');
                $table->string('qr_code_url')->nullable(); // URL QR Code
                $table->decimal('amount', 10, 2);
                $table->enum('status', ['pending', 'success', 'failed', 'cancelled'])->default('pending');
                $table->text('payment_gateway_response')->nullable(); // JSON response từ gateway
                $table->string('transaction_id')->nullable(); // ID từ payment gateway
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
            });
        } else {
            // Nếu bảng đã tồn tại, thêm các columns mới
            Schema::table('payments', function (Blueprint $table) {
                if (!Schema::hasColumn('payments', 'table_id')) {
                    $table->foreignId('table_id')->nullable()->after('id')->constrained('tables')->onDelete('set null');
                }
                if (!Schema::hasColumn('payments', 'order_group_id')) {
                    $table->string('order_group_id')->nullable()->after('table_id')->index();
                }
                if (!Schema::hasColumn('payments', 'qr_code_url')) {
                    $table->string('qr_code_url')->nullable();
                }
                if (!Schema::hasColumn('payments', 'payment_gateway_response')) {
                    $table->text('payment_gateway_response')->nullable();
                }
                if (!Schema::hasColumn('payments', 'transaction_id')) {
                    $table->string('transaction_id')->nullable();
                }
                if (!Schema::hasColumn('payments', 'paid_at')) {
                    $table->timestamp('paid_at')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

