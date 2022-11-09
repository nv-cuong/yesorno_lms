<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
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
            'title'         => ['required'],
            'category'      => ['required'],
            'time'          => ['required','numeric','min:1'],
            'description'   => ['required','min:5'],
            'question'      => ['required'],
            'course'        => ['required'],
        ];
    }
}
