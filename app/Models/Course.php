<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'statistic_id',
        'description',
        'begin_date',
        'end_date',
        'image',
    ];

    public function test()
    {
        return $this->belongsToMany(
            Test::class,
            'course_tests',
            'course_id',
            'test_id'
        );
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function statistic()
    {
        return $this->belongsTo(Statistic::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function classStudies()
    {
        return $this->belongsToMany(
            ClassStudy::class,
            'class_study_courses',
            'course_id',
            'class_study_id'
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_courses',
            'course_id',
            'user_id'
        );
    }

    public function scopeSearch($query){
        if($key = request()->key){
            $query = $query-> where('title', 'like', '%'.$key.'%');
        }
        return $query;
    }
}
