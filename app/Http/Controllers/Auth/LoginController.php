<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

class LoginController extends Controller
{
    //
    public function login()
    {
        return view('login');
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->except('_token');

        try {
            $user = Sentinel::authenticate($credentials);
            if ($user) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            } else {
                $msg = 'The provided credentials do not match our records.';
            }
        } catch (NotActivatedException $n) {
            $msg = 'The user is note activation';
        } catch (ThrottlingException $t) {
            $msg = 'The user is banded in '
                . round($t->getDelay() / 60) . ' minute';
        }

        return back()->withErrors([
            'email' => $msg,
        ])->onlyInput('email');
    }
}
