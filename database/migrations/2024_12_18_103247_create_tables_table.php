<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('table_number')->unique(); // Số hiệu bàn
            $table->enum('status', ['available', 'reserved', 'occupied'])->default('available'); // Trạng thái bàn
            $table->integer('seats'); // Số chỗ ngồi
            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables');
    }
}
