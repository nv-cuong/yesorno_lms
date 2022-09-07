<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required|min:8',
            'password'     => 'required|confirmed|min:8',
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [
         
            'old_password.required'     => 'Bạn chưa nhập mật khẩu cũ',
            'password.required'     => 'Bạn nhập nhập mật khẩu mới',
            'old_password.min'     => 'password phải lớn hơn 8 kí tự',
            'password.min'     => 'password phải lớn hơn 8 kí tự',
            
        ];
    }
}
