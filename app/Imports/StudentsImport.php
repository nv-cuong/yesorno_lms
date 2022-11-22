<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel , WithHeadingRow
{

    public function headingRow() : int
    {
        return 1;
    }

    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //
    }
}
