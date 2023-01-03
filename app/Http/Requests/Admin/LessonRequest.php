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
            'content' =>    ['required', 'min:20'],
            'published' =>  ['required', 'date'],
            'path_zip' =>   ['max:10000'],
        ];
    }
}
