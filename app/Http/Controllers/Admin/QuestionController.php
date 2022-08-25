<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function getData()
    {
        $questions = Question::query();

        return DataTables::of($questions)
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> 
                          <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {

        return view('Admin.questions.index');
    }

    public function create()
    {
        return view('Admin.questions.create');
    }

    public function store(Request $request)
    {
        $question_item = $request->except('_token');


        try {
            $question = Question::create([
                'content'          => $question_item['content'],
                'course_id'   => $question_item['course_id'],
                'category'      => $question_item['category'],
                'score'         => $question_item['score'],
            ]);
        } catch (\Throwable $t) {

            throw new ModelNotFoundException();
        }

        return redirect(route('question.index'))->with('msg', 'Product is not exitsting');
    }
}
