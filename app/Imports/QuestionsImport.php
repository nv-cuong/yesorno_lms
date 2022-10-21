<?php

namespace App\Imports;

use App\Jobs\Question\Import;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class QuestionsImport implements  ToModel, WithHeadingRow
{
    public function headingRow() : int
    {
        return 1;
    }
 
    public function model(array $row)
    {
        if($row['category'] == 0) {
            if($row['course_id']) {
                $question = new Question([
                    'course_id' => $row['course_id'],
                    'category' => $row['category'],
                    'content' => $row['content'],
                    'score' => $row['score'],
                ]);
            }
        } elseif ($row['category'] == 1) {
            if($row['category'] == 0) {
                $question = new Question([
                    'content' => $row['content'],
                    'course_id' => $row['course_id'],
                    'category' => $row['category'],
                    'score' => $row['score']
                ]);
                for ($q = 1; $q <= 4; $q++) {
                    
                }
            }
        }
        // if ($row['course_id']){
        //     return new Question([
        //         'course_id' => $row['course_id'],
        //         'category' => $row['category'],
        //         'content' => $row['content'],
        //         'score' => $row['score'],
        //     ]);
        // }
    }
}
