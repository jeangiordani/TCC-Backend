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
        Schema::create('mock_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('mock_exam_id')
                ->constrained(
                    table: 'mock_exams',
                    column: 'id',
                    indexName: 'mock_answers_mock_exam_id_foreign'
                );
            $table->foreignUuid('question_id')
                ->constrained(
                    table: 'questions',
                    column: 'id',
                    indexName: 'mock_answers_question_id_foreign'
                );
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_answers');
    }
};
