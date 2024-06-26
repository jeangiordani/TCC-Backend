<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'question_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
