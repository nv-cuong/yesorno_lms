<?php

namespace App\Http\Requests\Auth\User;

use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = Sentinel::getRoles()->pluck('slug');
        if ($role[0] == 'admin') {
            return true;
        }
        
        $id = $this->route()->parameter('user');
        $user = User::find($id);
        if($user->roles[0]->id == 2 || $user->roles[0]->id == 1)
            return abort(403, 'Unauthorized action.');
        else
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'      => 'required|digits:10',
            'role'       => 'required',
            'stu_id'     => 'required|unique:users,stu_id',
        ];
        if ($this->getMethod() == 'POST') {
            $rules['password']   = 'required|confirmed|min:8';
            $rules['email']      = 'required|unique:users|email';
        }
        return $rules;
    }
}
