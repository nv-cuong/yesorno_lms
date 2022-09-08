<?php

namespace App\Http\Requests\Auth\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|regex:/(^[A-Za-z0-9_-_ ]+$)+/',
            'last_name'  => 'required|regex:/(^[A-Za-z0-9_-_ ]+$)+/',
            'phone'      => 'required|min:10|numeric',
            'email'      => 'required|email',
            'role'       => 'required',
            //'password'   => 'required|confirmed|min:8',
        ];

       
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [
         
            'first_name.required'     => 'Bạn chưa nhập first_name',
            'last_name.required'     => 'Bạn chưa nhập last_name',
            'phone.required'     => 'Bạn chưa nhập phone',
            'phone.min'     => 'Phone phải nhỏ hơn 10 số',
            'phone.numeric'     => 'Bạn phải nhập dạng số',
            'email.required'     => 'Bạn chưa nhập email',
           
            'email.email'     => 'email chưa đúng định dạng',
            'role.required'     => 'Bạn chưa nhập role',
            'password.required'     => 'Bạn chưa nhập password',
            'password.min'     => 'Password phải từ 8 kí tự trở lên',
            //'password.confirmed'     => 'Password xác nhận không đúng',
        ];
    }
}
