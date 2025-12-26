<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            if (!Schema::hasColumn('tables', 'zone')) {
                $table->string('zone', 50)->nullable()->after('id');
                $table->index('zone');
            }

            if (!Schema::hasColumn('tables', 'code')) {
                $table->string('code', 20)->nullable()->after('id');
                $table->unique('code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            if (Schema::hasColumn('tables', 'zone')) {
                $table->dropIndex(['zone']);
                $table->dropColumn('zone');
            }

            if (Schema::hasColumn('tables', 'code')) {
                $table->dropUnique(['code']);
                $table->dropColumn('code');
            }
        });
    }
};
