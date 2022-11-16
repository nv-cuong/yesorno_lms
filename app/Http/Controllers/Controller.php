<?php

namespace App\Http\Controllers;
use App\Models\UserTest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Contracts\View\View;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function compose(View $view)
    {
        $user = Sentinel::getUser();
        if ($user) {
            $user_tests = UserTest::where('status', 1)->get();
            $count_user_tests = $user_tests->count();
            $view->with('user_tests', $user_tests);
            $view->with('count_user_tests', $count_user_tests);
        }
    }
}
