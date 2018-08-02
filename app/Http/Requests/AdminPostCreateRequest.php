<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminPostCreateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|min:5|max:50',
            'category_id' => 'required',
            'content' => 'required',
        ];
    }

    public function messages() {
        return [
            'category_id.required' => 'Category is required',
        ];
    }
}
