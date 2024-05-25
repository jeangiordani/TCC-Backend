<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $table = 'alternatives';

    protected $fillable = ['description', 'letter', 'is_correct', 'question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
