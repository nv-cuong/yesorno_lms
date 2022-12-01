<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsImportForm implements  WithHeadings
{


    public function headings(): array {
        return [
            ["ID","Email","Tên đầu","Tên cuối", "Số điện thoại","Địa chỉ","Ngày sinh","Giới tính"],
            ['SV001',"dong2000pl@gmail.com","Dong","Hoang","0346076810","Phu Luong, Thai Nguyen","2000-01-23","male"],
        ];
    }

}
