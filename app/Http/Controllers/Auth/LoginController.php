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
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login()
    {
        return view('login');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|unknown
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->except('_token');
    


        try {
            $remember = false;
            if($request->has('rememberme')) {
                $remember = true;
            }

            $user = Sentinel::authenticate($credentials, $remember);
            
            if ($user) {   
                $request->session()->regenerate();
                if ($user-> inRole ('student')){
                    return redirect()->intended(route('home'));
                }else{
                    return redirect()->intended(route('dashboard'));
                }
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
