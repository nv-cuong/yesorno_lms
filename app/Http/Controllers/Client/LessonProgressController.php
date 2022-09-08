<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function lessonProgress(Request $request){
        Lesson::where('id', 3)
        ->update(['title' => "abc"]);
        return 'Success! ajax in laravel 5';
    }
}
