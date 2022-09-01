<?php

namespace App\Http\Requests\Admin\Class;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' =>           ['required', 'max:255'],
            'course_id' =>      ['required'],
            'description' =>    ['required', 'min:20'],
            'schedule' =>         ['required'],
        ];
    }
}
