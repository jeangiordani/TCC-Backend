<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExam extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'mock_exams';

    protected $fillable = [
        'title',
        'description',
        'qty_questions',
        'kowledge_area_id',
        'user_id',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function knowledge_area()
    {
        return $this->belongsTo(KnowledgeArea::class);
    }
}
