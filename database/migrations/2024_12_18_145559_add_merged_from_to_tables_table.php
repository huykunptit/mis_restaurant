<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMergedFromToTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->string('merged_from')->nullable()->after('is_merged'); // Track original tables
        });
    }
    
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropColumn('merged_from');
        });
    }
}
