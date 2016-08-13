<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateDatabasesRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'tables_name' => 'required',
            // 'fields_name' => 'required | string',
            // 'fields_data_type' => 'required',
            // 'fields_length' => 'required',
            // 'default_value' => 'required',
            // 'tables.*.fields_name' => 'required|max:2'
        ];
    }
}
