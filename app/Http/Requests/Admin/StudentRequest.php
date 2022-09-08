<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone'=>['required','numeric','digits:10'],
            'first_name'=>['required','max:255'],
            'last_name'=>['required','max:255'],
            'birthday' =>['required','date_format:Y-m-d','before:-13 years'], // default > 13
            'gender'=>['required']
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [
        'phone.required' => 'Số điện thoại không được bỏ trống',
        'phone.numeric' => 'Số điện thoại không được bao gồm ký tự',
        'phone.digits'=> 'Số điện thoại phải có đủ 10 số',
        'first_name.required' => 'Họ không được bỏ trống',
        'first_name.max' => 'Họ quá dài',
        'last_name.required' => 'Tên không được bỏ trống',
        'last_name.max' => 'Tên quá dài',
        'birthday.required'=>'Ngày sinh không được bỏ trống',
        'birthday.date-format'=>'Ngày tháng năm sinh sai',
        'birthday.before'=>'Tuổi phải lớn hơn 13',
        'gender.required'=>'Giới tính không được bỏ trống',
        ];
    }
}
