<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array {
        return ["ID","Khóa học", "Loại câu hỏi","Nội dung","Câu trả lời","Điểm"];
    }
    
    public function collection()
    {
        return Question::select('id','course_id','category','content','answer','score')->with('answers')
        ->get();
    }

    
}
