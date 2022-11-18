<?php
namespace App\View\Composers;

use Illuminate\View\View;

use App\Models\UserTest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ProfileComposer
{

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = Sentinel::getUser();

        if ($user) {
            $user_tests = UserTest::where('user_id', $user->id)
            ->where('status', 0)->get();
            $count_user_tests = $user_tests->count();
            $view->with('user_tests', $user_tests);
            $view->with('count_user_tests', $count_user_tests);
        }
    }
}