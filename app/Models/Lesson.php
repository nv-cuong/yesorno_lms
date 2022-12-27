<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }


    /**
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * @return BelongsToMany
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(
            Question::class,
            'question_lessions',
            'question_id',
            'lession_id'
        );
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_lessons',
            'lesson_id',
            'user_id'
        )->withPivot('status');
    }

    public function checkUserStudy($userId){
        return $this->users()
        ->where('user_lessons.user_id', $userId)
        ->where('user_lessons.status', 1)
        ->exists();
    }
}
