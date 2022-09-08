<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed|min:8',
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return[
            'email.required' => 'Trường email không được để trống.',
            'email.email' => 'Nhập đúng địa chỉ e-mail',
            'password.required' => 'Trường mật khẩu không được để trống',
            'first_name.required' => 'Trường tên không được để trống',
            'last_name.required' => 'Trường họ không được để trống',
            'email.unique' => 'E-mail đã đăng kí tài khoản',
        ];
    }
}
