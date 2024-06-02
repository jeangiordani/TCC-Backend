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
        Schema::table('mock_answers', function (Blueprint $table) {
            //
            $table->foreignId('alternative_id')
                ->nullable(true)
                ->constrained(
                    table: 'alternatives',
                    column: 'id',
                    indexName: 'mock_answers_alternative_id_foreign'
                )
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mock_answers', function (Blueprint $table) {
            //
            $table->dropForeign(['alternative_id']);
            $table->dropColumn('alternative_id');
        });
    }
};
