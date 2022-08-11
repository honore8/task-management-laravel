<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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

            'name' => 'required|max:255|unique:tasks,name',
            'description' => 'required|max:255|unique:tasks,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Project name field is required',
            'name.unique' => 'The task name is already added',
            'description.required' => 'The project description field is required',

        ];
    }
}
