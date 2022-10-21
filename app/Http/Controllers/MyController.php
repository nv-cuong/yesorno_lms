<?php
   
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Exports\QuestionsExport;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;
  
class MyController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {
       return view('admin.questions.index');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new QuestionsExport, 'Question.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        Excel::import(new QuestionsImport(), $request->file('import_question'));
        return redirect()->back()->with('success', 'Success!!!');
    }
}
