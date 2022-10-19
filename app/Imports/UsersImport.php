<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;



class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Question([
            'content'     => $row[0],
            'course_id'    => $row[1], 
            'category' => $row[2],
            'score' => $row[3],
        ]);
    }
}
