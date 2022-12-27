<?php

namespace App\Imports;

use App\Mail\SendEmailAccount;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Mail;

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
        DB::beginTransaction();
        try {
            if($row['email'] ) {
                $pass = str_random(8); 
                $data = [ 
                    'email' => $row['email'],
                    'stu_id'=> $row['id'],
                    'password' => $pass,
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'phone' => $row['phone'],
                    'address' => $row['address'],
                    'birthday' => $row['birthday'],
                    'gender' => $row['gender'],
                ];
                $newUser = Sentinel::registerAndActivate($data);
                $newUser->roles()->attach(5); 
                
                Mail::to($row['email'])->send(new SendEmailAccount($data));

             
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }
        DB::commit();
    }
}
