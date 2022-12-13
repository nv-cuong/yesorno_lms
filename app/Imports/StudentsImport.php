<?php

namespace App\Imports;

use App\Mail\SendEmail;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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
                $user = [ 
                    'email' => $row['email'],
                    'stu_id'=> $row['id'],
                    'password' => Hash::make(str_random(8)),
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'phone' => $row['phone'],
                    'address' => $row['address'],
                    'birthday' => $row['birthday'],
                    'gender' => $row['gender'],
                ];
                $newUser = Sentinel::registerAndActivate($user);
                $newUser->roles()->attach(5);
                // dd($row['email']);    
                
                Mail::to($row['email'])->send(new SendEmail($user));

             
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }
        DB::commit();
    }
}
