<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */


    public function headings(): array {
        return ["ID","Email","Tên đầu","Tên cuối", "Số điện thoại","Địa chỉ","Ngày sinh","Giới tính"];
    }


    public function collection()
    {
        return User::select('id','email','first_name','last_name','phone','address','birthday','gender')
        ->leftjoin('role_users','users.id','=','role_users.user_id')->where('role_id','=','5')
        ->get();
    }
}
