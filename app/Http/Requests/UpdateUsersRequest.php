<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class UpdateUsersRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && !empty($this->id)) {
            if (Auth::user()->rules_id == Auth::user()->rulesAdmin
                || Auth::user()->id == $this->id
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric|exists:users,id',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$this->id,
            'user_name' => 'required|max:255|unique:users,user_name,'.$this->id,
            'password' => 'min:6|confirmed',
            'rules_id' => 'numeric|exists:rules,id,status,1',
            'image' => 'image',
        ];
    }
}
