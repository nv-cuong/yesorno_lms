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
       $a=0;
        foreach($this->true as $question_id => $score)
        {
            
            $question =Question::find($question_id)->score;
            $a = 'true'.'['.$question_id.']';
            $a++;
           
        }
        return [
            "true.*" => 'required',
        ];
        
    }
}
