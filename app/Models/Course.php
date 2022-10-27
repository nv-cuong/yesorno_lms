<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model {
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

    public function tests(): BelongsToMany {
        return $this->belongsToMany(
            Test::class,
            'course_tests',
            'course_id',
            'test_id'
        );
    }

    public function units(): HasMany {
        return $this->hasMany(Unit::class);
    }

    public function statistic(): BelongsTo {
        return $this->belongsTo(Statistic::class);
    }

    public function questions(): HasMany {
        return $this->hasMany(Question::class);
    }

    public function classStudies(): BelongsToMany {
        return $this->belongsToMany(
            ClassStudy::class,
            'class_study_courses',
            'course_id',
            'class_study_id'
        );
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(
            User::class,
            'user_courses',
            'course_id',
            'user_id'
        )->withPivot('status');
    }

    /**
     * Scope a query request key.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query) {
        if ($key = request()->key) {
            $query = $query->where('title', 'like', '%' . $key . '%');
        }
        return $query;
    }
}
