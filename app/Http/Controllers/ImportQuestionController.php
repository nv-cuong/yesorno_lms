<?php
   
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Exports\QuestionsExport;
use App\Exports\QuestionsImportForm;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Question\ImportQuestionRequest;
  
class ImportQuestionController extends Controller
{

   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new QuestionsExport, 'Question.xlsx');
    }

    public function importform()
    {
        return Excel::download(new QuestionsImportForm, "QuestionImportForm.xlsx");
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(ImportQuestionRequest $request) 
    {
        Excel::import(new QuestionsImport(), $request->file('import'));
        return redirect()->back()->with('success', 'Success!!!');
    }
}

