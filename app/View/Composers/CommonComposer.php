<?php
namespace App\View\Composers;

use Illuminate\View\View;

use App\Models\UserTest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Route;

class CommonComposer
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
            $user_tests = UserTest::where('user_tests.status', 1)
                ->where('score', '')
                ->leftJoin('course_tests as ct', 'ct.test_id', 'user_tests.test_id' )
                ->join('courses', 'ct.course_id', 'courses.id')
                ->where('teacher_id', $user->id)
                ->get();
            $count_user_tests = $user_tests->count();
            $view->with('user', $user);
            $view->with('user_tests', $user_tests);
            $view->with('count_user_tests', $count_user_tests);
        }
        $route_prefix = Route::current()->getPrefix();
        $view->with('route_prefix_name', $route_prefix);
    }
}