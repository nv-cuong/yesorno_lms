<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTestAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_test_id', 'question_id', 'answer','correct'];
}
