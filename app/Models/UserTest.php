<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'user_id',
        'score',
        'status',
        'started_at',
        'submitted_at',
    ];

    /**
     * user_test_anwsers relation
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(UserTestAnswer::class);
    }

    /**
     * @return BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
    
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
