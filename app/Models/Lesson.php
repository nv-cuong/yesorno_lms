<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'slug',
        'unit_id',
        'path',
        'config',
        'title',
        'published',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'question_lessions',
            'question_id',
            'lession_id'
        );
    }
    
}
