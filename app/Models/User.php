<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;

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
    ];

    public function tests()
    {
        return $this->belongsToMany(
            Test::class,
            'user_tests',
            'user_id',
            'test_id'
        );
    }

    public function classStudies()
    {
        return $this->belongsToMany(
            ClassStudy::class,
            'class_study_users',
            'user_id',
            'class_study_id'
        );
    }

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'user_courses',
            'user_id',
            'course_id'
        );
    }
    public function scopeSearch($query){
        if($key = request()->key){
            $query = $query-> where('first_name', 'like', '%'.$key.'%')
                            ->orWhere('last_name', 'like', '%'.$key.'%');
        }
        return $query;
    }
}
