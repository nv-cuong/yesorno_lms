<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserTestAnswer;
class UserTest extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['test_id', 'user_id', 'score','status'];

    public function answers()
    {
        return $this->hasMany(UserTestAnswer::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
