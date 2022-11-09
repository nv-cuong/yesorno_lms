<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Cartalyst\Sentinel\Roles\EloquentRole;

class Role extends EloquentRole
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'permissions',
        'created_at',
        'updated_at'
    ];
}
