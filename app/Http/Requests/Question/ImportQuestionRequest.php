<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class ImportQuestionRequest extends FormRequest
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
            'import' => ['required'],
        ];;
    }


     /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        $rule =  [
            'import.required'     => 'Bạn chưa chọn file',
        ];
        return $rule;
    }
}

