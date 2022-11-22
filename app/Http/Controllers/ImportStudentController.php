<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;

class ImportStudentController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new StudentsExport, 'Students.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */

    public function import(Request $request) 
    {
        Excel::import(new StudentsImport(), $request->file('import'));
        return redirect()->back()->with('success', 'Success!!!');
    }

}
