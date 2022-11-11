<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        $rules = [
            'content' => "required|max:250|unique:questions,content," . $this->id,
            'course_id' => ['required'],
            'score' => ['required', 'integer', 'min:1'],
        ];

        if ($this->category == 1) {
            $rules['is_correct'] = ['required'];
            for ($idx = 0; $idx < 4; $idx++) {
                $rules['answer1.' . $idx] = "required";
            }
        } 

        return $rules;
    }

    public function messages()
    {
        return [
            'answer1.*.required' => 'Trường tên đáp án không được bỏ trống',
        ];
    }
}
