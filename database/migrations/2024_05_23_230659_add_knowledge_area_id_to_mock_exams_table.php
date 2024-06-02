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
        Schema::table('mock_exams', function (Blueprint $table) {
            $table->foreignId('knowledge_area_id')
                ->nullable(true)
                ->constrained(table: 'knowledge_areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mock_exams', function (Blueprint $table) {
            $table->dropForeign(['knowledge_area_id']);
            $table->dropColumn('knowledge_area_id');
        });
    }
};
