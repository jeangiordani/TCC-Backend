<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExamAnswer extends Model
{
    use HasFactory;

    protected $table = 'mock_answers';

    protected $fillable = [
        'mock_exam_id',
        'question_id',
        'alternative_id',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function mock_exam()
    {
        return $this->belongsTo(MockExam::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}
