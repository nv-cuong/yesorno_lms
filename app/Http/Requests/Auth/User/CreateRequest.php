<?php

namespace App\Http\Requests\Auth\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'phone'      => 'required|digits:10',
            'email'      => 'required|unique:users|email',
            'role'       => 'required',
            'password'   => 'required|confirmed|min:8',
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
            'phone.required'     => 'Bạn chưa nhập số điện thoại',
            'phone.digits'     => 'Số điện thoại phải có 10 chữ số',
            'email.required'     => 'Bạn chưa nhập email',
            'email.unique'     => 'Email đã tồn tại',
            'email.email'     => 'Email chưa đúng định dạng',
            'role.required'     => 'Bạn chưa nhập role - phân quyền',
            'password.required'     => 'Bạn chưa nhập mật khẩu',
            'password.min'     => 'Mật khẩu phải từ 8 kí tự trở lên',
            'password.confirmed'     => 'Mật khẩu xác nhận không đúng',
        ];
    }
    
}
