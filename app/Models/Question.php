<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['statement', 'post_statement', 'is_active', 'knowledge_area_id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function knowledge_area()
    {
        return $this->belongsTo(KnowledgeArea::class);
    }

    public function alternatives()
    {
        return $this->hasMany(Alternative::class, 'question_id', 'id');
    }

    public function image()
    {
        return $this->hasOne(QuestionImage::class, 'question_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'question_id', 'id');
    }
}
