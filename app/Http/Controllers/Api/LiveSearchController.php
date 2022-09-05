<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class LiveSearchController extends Controller
{
    //
    public function liveSearch(){
        $data = Course::search()->get();
        return $data;
    }
}
