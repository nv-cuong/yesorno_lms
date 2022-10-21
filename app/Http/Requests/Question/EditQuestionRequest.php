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
            $rules = [
                'content' => ['required', 'max:250', 'unique:questions'],
                'course_id' => ['required'],
                'score' => ['required', 'integer', 'min:1'],
                'is_correct' => ['required'],
            ];

            for ($idx = 0; $idx < 4; $idx++) {
                $rules['answer1.' . $idx] = "required";
            }

            return $rules;
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
        $rule =  [
            'content.required'     => 'Bạn chưa nhập tên câu hỏi',
            'is_correct.required' => 'Bạn chưa chọn câu trả lời đúng',
            'content.max'     => 'Câu hỏi quá dài',
            'score.required'     => 'Bạn chưa nhập điểm',
            'score.integer'     => 'Điểm phải dạng số nguyên',
            'score.min'     => 'Điểm phải lớn hơn 1',
            'answer1.*.required'     => 'Bạn chưa nhập câu trả lời',
        ];

        return $rule;
    }
}
