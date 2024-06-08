<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'path',
        'type',
        'subject'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    protected $table = 'medias';

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->{$model->getKeyName()} = (string) Str::uuid();
    //     });

    //     static::saving(function ($model) {
    //         if ($model->isDirty('path') && !empty($model->path)) {
    //             $extension = pathinfo($model->path, PATHINFO_EXTENSION);
    //             $filename = $model->id . '.' . $extension;
    //             $model->path = 'uploads/' . $filename;
    //         }
    //     });
    // }
}
