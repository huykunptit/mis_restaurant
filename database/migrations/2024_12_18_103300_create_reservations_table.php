<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK tới bảng users
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade'); 
            $table->foreignId('menu_id')->nullable()->constrained('menus')->onDelete('set null'); 
            $table->foreignId('menu_option_id')->nullable()->constrained('menu_options')->onDelete('set null'); 
            $table->dateTime('reservation_time'); 
            $table->enum('status', ['pending', 'confirmed', 'canceled'])->default('pending'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
