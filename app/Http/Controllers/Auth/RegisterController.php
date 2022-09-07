<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Show the form for the user registration.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('admin.register');
    }

    /**
     * Handle posting of the form for the user registration.
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processRegistration(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->offsetSet('created_by', 'Register');
            $request->offsetSet('updated_by', 'Register');

            if ($user = Sentinel::register($request->all())) {
                $activation = Activation::create($user);

                //Attach the user to the role
                $role = Sentinel::findRoleBySlug('student');
                $role->users()
                ->attach($user);

                $code = $activation->code;

                $sent = Mail::send(
                    'admin.auth.emails.activate',
                    compact('user', 'code'),
                    function ($m) use ($user) {
                        $m->to($user->email)
                    ->subject('Activate Your Account');
                    }
                );

                //$sent = 1;

                if ($sent === 0) {
                    Session::flash('failed', __('auth.activation_email_unsuccessful'));

                    DB::commit();
                    return redirect()
                        ->back()
                        ->withInput();
                }

                DB::commit();

                Session::flash('success', __('auth.activation_email_successful'));

                return redirect()->route('login.form');
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::info($exception->getFile() . $exception->getLine() .':'. $exception->getMessage());
            Session::flash('failed', __('auth.activation_email_unsuccessful'));

            return redirect()->route('register.form');
        }
    }

    /**
     * Handle activation for the user registration.
     *
     * @param $userId
     * @param $code
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate($userId, $code)
    {
        $user = Sentinel::findById($userId);

        if (Activation::complete($user, $code)) {

            // Activation was successfull
            Session::flash('success', __('auth.activate_successful'));

            return redirect()->route('login.form');
        } else {
            Activation::removeExpired();
            // Activation not found or not completed.
            Session::flash('failed', __('auth.activate_unsuccessful'));

            return redirect()->route('register.form');
        }
    }
}
