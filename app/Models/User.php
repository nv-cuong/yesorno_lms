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
        'first_name',
        'last_name',
        'last_login',
        'permissions',
<<<<<<< HEAD
    ];

}
=======
        'age',
        'gender',
    ];

    public function findForPassport($username) {
        return self::where('email', $username)->first(); // change column name whatever you use in credentials
    }
}
>>>>>>> origin/develop
