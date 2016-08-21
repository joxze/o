<?php

namespace App\Http\Requests\Rules;

use App\Http\Requests\Request;
use Auth;

class CreateRulesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return true;
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
            'name' => 'required|max:50|unique:rules,name',
            'status' => 'required|in:0,1'
        ];
    }
}
