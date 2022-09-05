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
        'description',
        'schedule',
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

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'class_study_users',
            'class_study_id',
            'user_id',
        );
    }

    public function scopeSearch($query){
        if($key = request()->key){
            $query = $query-> where('name', 'like', '%'.$key.'%');
        }
        return $query;
    }
}
