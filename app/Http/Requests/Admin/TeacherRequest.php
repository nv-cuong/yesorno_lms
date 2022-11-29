<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'phone' => ['required', 'digits:10'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'birthday' => ['required', 'date_format:Y-m-d', 'before:-6 years'],
            'gender' => ['required'],
            'stu_id' => ['required', 'unique:users,stu_id,' . $this->id]
        ];
    }
}
