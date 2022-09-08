<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'title' =>          ['required', 'max:255'],
            'description' =>    ['required', 'min:20'],
            'status' =>         ['required', 'boolean'],
            'begin_date' =>     ['required', 'date'],
            'end_date' =>       ['required', 'date'],
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [
            'title.required'     => 'Bạn chưa nhập tên khóa học',
            'title.max'     => 'Tên khóa học phải ít 255 kí tự',
            'description.required'     => 'Bạn chưa nhập mô tả khóa học',
            'description.min'     => 'Mô tả phải nhiều hơn 20 ký tự',
            'status.required'     => 'Bạn chưa chọn loại khóa học',
            'begin_date.required'     => 'Bạn chưa chọn ngày bắt đầu',
            'end_date.required'     => 'Bạn chưa chọn ngày kết thúc',
        ];
    }
}
