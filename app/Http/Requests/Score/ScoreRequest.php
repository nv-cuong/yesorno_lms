<?php

namespace App\Http\Requests\Score;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class ScoreRequest extends FormRequest
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
            'student_id' => ['required'],   
        ];
       
    }
    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [

            'student_id.required'     => 'Bạn chưa chọn học viên !',    
        ];
    }

   
    
}
