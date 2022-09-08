<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'title' =>      ['required', 'max:255'],
            'unit_id' =>    ['required', 'numeric'],
            'content' =>    ['required', 'min:20'],
            'published' =>  ['required', 'date'],
            'path_zip' =>   ['max:10000'],
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [
            'title.required'     => 'Bạn chưa nhập tên bài học',
            'title.max'     => 'Tên bài học phải ít hơn 255 kí tự',
            'content.required'     => 'Bạn chưa nhập nội dung khóa học',
            'content.min'     => 'Nội dung phải nhiều hơn 20 ký tự',
            'published.required'     => 'Bạn chưa chọn ngày xuất',
            'path_zip.max'     => 'Tệp tải lên phải nhỏ hơn 10000Kb',
        ];
    }
}
