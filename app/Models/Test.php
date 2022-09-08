<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'category',
        'amount',
        'title',
        'published',
        'description',
    ];
    use HasFactory;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function course()
    {
        return $this->belongsToMany(
            Course::class,
            'course_tests',
            'test_id',
            'course_id'
        );
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function question()
    {
        return $this->belongsToMany(
            Question::class,
            'test_questions',
            'test_id',
            'question_id'
            
        );
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(
            User::class,
            'user_tests',
            'test_id',
            'user_id',
        );
    }
}
