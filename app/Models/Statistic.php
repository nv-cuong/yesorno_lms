<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'progress',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
