<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserCreateRequest extends FormRequest
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
            'name' => 'required|max:5',
            'email' => 'required|email|max:100',
            'role_id' => 'required',
            'is_active' => 'required',
            'password' => 'required|min:3|max:32'
        ];
    }

    public function messages() {
        return [
            'role_id.required' => 'Role is required',
            'is_active.required' => 'Status is required'
        ];
    }
}
