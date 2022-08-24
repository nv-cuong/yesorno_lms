<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class LogoutController extends Controller
{
    public function logout()
    {
        Sentinel::logout();
        return redirect(route('login'));
    }
}
