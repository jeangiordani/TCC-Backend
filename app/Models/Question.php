<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['statement', 'is_active', 'knowledge_area_id'];

    protected $casts = [
        'id' => 'uuid',
    ];

    public function knowledge_area()
    {
        return $this->belongsTo(KnowledgeArea::class);
    }
}
