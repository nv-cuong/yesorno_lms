<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Hashing\BcryptHasher;
class SentinelPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        Sentinel::setHasher( new BcryptHasher() );

        $user = Sentinel::check();

        if ( ! $user ) {
            return redirect()->guest( 'login' );
        }

        #This Is Root User?
        $roles = Sentinel::getRoles()->pluck('slug')->all();
        if ( is_array($roles) ) {
            if ( in_array('admin', $roles,) || in_array('manager', $roles,) 
            || in_array('teacher', $roles,) || in_array('classmanager', $roles,)) {
                return $next( $request );
            }
        }

        #Check Access When User Is Not Root
        if ( $user->hasAccess( $role ) ) {
            return $next( $request );
        }

        if ( $request->ajax() || $request->wantsJson() ) {
            return response( trans( 'backpack::base.unauthorized' ), 401 );
        }

        return abort(404, 'Unauthorized action.');
    }
}
