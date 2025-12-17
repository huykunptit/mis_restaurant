<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->boolean('is_merged')->default(0); // 1 = active, 0 = merged
        });
    }
    
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropColumn('is_merged');
        });
    }
    
}
