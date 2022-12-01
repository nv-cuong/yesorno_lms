<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionsImportForm implements  WithHeadings
{


    public function headings(): array {
        return [
            ["stt","course_id","category","content", "answer1","answer2","answer3","answer4","result1","result2","result3","result4","result0","score"],
            ['1',"6","1","1 + 1 = ?","1","2","3","2","0","1","0","1","","90"],
            ['2',"6","2","1 + 1 = 2"," "," "," "," "," "," "," "," ","1","90"," "," ","category: 1 => multiple choice"],
            ['3',"6","2","1 + 1 = 2"," "," "," "," "," "," "," "," ","0","90"," "," ","                    2 => true false"],
        ];
    }

}
