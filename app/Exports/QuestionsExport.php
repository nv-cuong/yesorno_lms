<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;

class QuestionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array {
        return ["Khóa học", "Loại câu hổi","Nội dung","Câu trả lời","Điểm"];
    }
    
    public function collection()
    {
        return Question::select('course_id','category','content','answer','score')->get();
    }

    
}
