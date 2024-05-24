<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeArea extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    public function mock_exams()
    {
        return $this->hasMany(MockExam::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
