<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function search( Request $request){
        $data = Course::where('title','like', '%' .$request->keyword . '%')
            ->with('units')
            ->paginate(6);
        return view('client.modules.search_result', compact('data'));
    }
}
