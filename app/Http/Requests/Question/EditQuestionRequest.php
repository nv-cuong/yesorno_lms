<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class EditQuestionRequest extends FormRequest
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

        if ($this->category == 1) {
            return [
                'content' => ['required', 'max:250'],
                'course_id' => ['required'],
                'score' => ['required', 'integer', 'min:1'],
                'content_1' => ['required'],
                'content_2' => ['required'],
                'content_3' => ['required'],
                'content_4' => ['required'],

            ];
        } else {
            return [
                'content' => ['required', 'max:250'],
                'course_id' => ['required'],
                'score' => ['required', 'integer', 'min:1'],

            ];
        }
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [

            'content.required'     => 'Bạn chưa nhập tên câu hỏi',
            'content.max'     => 'Câu hỏi quá dài',
            'score.required'     => 'Bạn chưa nhập điểm',
            'score.integer'     => 'Điểm phải dạng số nguyên',
            'score.min'     => 'Điểm phải lớn hơn 1',
            'content_1.required'     => 'Bạn chưa nhập câu trả lời',
            'content_2.required'     => 'Bạn chưa nhập câu trả lời',
            'content_3.required'     => 'Bạn chưa nhập câu trả lời',
            'content_4.required'     => 'Bạn chưa nhập câu trả lời',
        ];
    }
}
