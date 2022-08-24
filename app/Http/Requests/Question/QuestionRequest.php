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
         
        if($this->category == 1)
        {
            return [
                'content' => ['required', 'max:255'],
                'course_id' => ['required'],
                'score' => ['required', 'integer' ,'min:1'],  
                
            ];
        }
        else{
            return [
                'content' => ['required', 'max:50'],
                'course_id' => ['required'],      
                'score' => ['required', 'integer' ,'min:1'],  
            
            ];
        }
       
    }
    public function messages()
    {
        return [
         
            'content.required'     => 'Bạn chưa nhập tên câu hỏi',
            'content.max'     => 'Câu hỏi quá dài',
            'score.required'     => 'Bạn chưa nhập điểm',
            'score.integer'     => 'Điểm phải dạng số nguyên',
            'score.min'     => 'Điểm phải lớn hơn 1',
        
        ];
    }

}
