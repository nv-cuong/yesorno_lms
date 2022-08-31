<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [

        'course_id',
        'content',
        'answer',
        'category',
        'score',
    ];
       
   
    public function answer()
    {
        return $this->hasMany(Answer::class);
    }

    public function test()
    {
        return $this->belongsToMany(
            Test::class,
            'test_questions',
            'question_id',
            'test_id'
        );
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}