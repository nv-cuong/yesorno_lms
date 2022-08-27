<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(){
        return view('admin.register');
    }

    public function processRegistration(RegisterRequest $request)
    {
        $student = Sentinel::register($request->all());
        $role = Sentinel::findRoleBySlug('student');
                $role->users()
                ->attach($student);
    }
}
