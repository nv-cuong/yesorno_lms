<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends EloquentUser
{
    use HasFactory;
    use Notifiable;
    use Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'phone',
        'birthday',
        'address',
        'age',
        'gender',
        'first_name',
        'last_name',
        'last_login',
        'permissions',
        'name_img',
        'path',
        'stu_id',
    ];

    /**
     * @return BelongsToMany
     */
    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(
            Test::class,
            'user_tests',
            'user_id',
            'test_id',
        )->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function classStudies(): BelongsToMany
    {
        return $this->belongsToMany(
            ClassStudy::class,
            'class_study_users',
            'user_id',
            'class_study_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(
            Course::class,
            'user_courses',
            'user_id',
            'course_id'
        )->withPivot('status');
    }


    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(
            Lesson::class,
            'user_lessons',
            'user_id',
            'lesson_id'
        )->withPivot('status');
    }


    /**
     *
     * @param int $class_id
     * @return mixed
     */
    public function hasClass($class_id)
    {
        return $this->classStudies()
            ->where('class_study_id', $class_id)
            ->exists();
    }

    /**
     *
     * @param int $course_id
     * @return mixed
     */
    public function hasCourse($course_id)
    {
        return $this->courses()
            ->where('course_id', $course_id)
            ->exists();
    }

    /**
     * Scope a query request key.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query)
    {
        if ($key = request()->key) {
            $query = $query->where('first_name', 'like', '%' . $key . '%')
                ->orWhere('last_name', 'like', '%' . $key . '%');
        }
        return $query;
    }

}
