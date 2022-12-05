<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsImportForm implements  WithHeadings
{


    public function headings(): array {
        return [
            ["id","email","first_name","last_name", "phone","address","birthday","gender"],
            ['SV001',"dong2000pl@gmail.com","Dong","Hoang","0346546810","Phu Luong, Thai Nguyen","2000-01-23","male"],
            ['SV002',"nhi2000pl@gmail.com","Nhi","Pham","034603410","Tho Lam, Thai Nguyen","2000-06-10","female"],
        ];
    }

}
