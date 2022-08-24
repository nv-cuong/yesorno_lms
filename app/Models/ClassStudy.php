<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'amount',
        'description',
    ];
    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'class_study_courses',
            'class_study_id',
            'course_id',

        );
    }
}
