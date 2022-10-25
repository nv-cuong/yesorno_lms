<?php

namespace App\Imports;

use App\Jobs\Question\Import;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;



class QuestionsImport implements  ToModel, WithHeadingRow
{
    

    public function headingRow() : int
    {
        return 1;
    }

    // public function model(array $row)
    // {
    //             if ($row['course_id']){
    //                 return new Question([
    //                     'course_id' => $row['course_id'],
    //                     'category' => $row['category'],
    //                     'content' => $row['content'],
    //                     'score' => $row['score'],
    //         ]);      
    //     }
    // }
 
    public function model(array $row){
        if($row['category'] == 0) {
            if($row['course_id']) {
                new Question([
                    'course_id' => $row['course_id'],
                    'category' => $row['category'],
                    'content' => $row['content'],
                    'score' => $row['score'],
                ]);
            }
        } 
        elseif ($row['category'] == 1) 
        {
            if($row['course_id']) {
                $question = new Question([
                    'content' => $row['content'],
                    'course_id' => $row['course_id'],
                    'category' => $row['category'],
                    'score' => $row['score'],
                ]);
                // $question = DB::table('questions')->where('category','1')
                // ->value('id');
                // dd($question);
                for ($q = 1; $q <= 4; $q++) 
                {

                    switch ($q) 
                    {
                        case 1:
                            Answer::create([
                                'question_id' => $question,
                                'content' => $row['answer1'],
                                'checked' => $row['result1'],
                            ]);
                           break;
                        case 2:
                            Answer::create([
                                'question_id' => $question,
                                'content' => $row['answer2'],
                                'checked' => $row['result2'],
                            ]);
                            break;
                        case 3:
                            Answer::create([
                                'question_id' => $question,
                                'content' => $row['answer3'],
                                'checked' => $row['result3'],
                            ]);
                            break;
                            case 4:
                                Answer::create([
                                    'question_id' => $question,
                                    'content' => $row['answer4'],
                                    'checked' => $row['result4'],
                                ]);
                                break;
                    }
                }
            } 
        }
        else
        {
            {
                if($row['course_id']) 
                { 
                    new Question([
                        'course_id' => $row['course_id'],
                        'category' => $row['category'],
                        'content' => $row['content'],
                        'score' => $row['score'],
                        'answer' => $row['result0'],
                    ]);
                }
            }
        }
    }
}
