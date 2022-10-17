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
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'      => 'required|digits:10|numeric',
            'email'      => 'required|email',
            'address'    => 'required',
            'role'       => 'required',
        ];

       
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [
         
            'first_name.required'     => 'Bạn chưa nhập tên',
            'last_name.required'     => 'Bạn chưa nhập họ và tên đệm',
            'phone.required'     => 'Bạn chưa nhập phone',
            'phone.digits'     => 'Số điện thoại có 10 số',
            'phone.numeric'     => 'Số điện thoại phải nhập dạng số',
            'email.required'     => 'Bạn chưa nhập email',
            'email.email'     => 'Email chưa đúng định dạng',
            'address.required'     => 'Bạn chưa nhập địa chỉ',
            'role.required'     => 'Bạn chưa nhập role',
            'password.required'     => 'Bạn chưa nhập mật khẩu',
            'password.min'     => 'Mật khẩu phải từ 8 kí tự trở lên',
        ];
    }
}
