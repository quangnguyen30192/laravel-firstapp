<?php

namespace App\Http\Requests;

class AdminUserEditRequest extends AdminUserCreateRequest {
    public function rules() {
        return [
            'name' => 'required|max:5',
            'email' => 'required|email|max:100',
            'role_id' => 'required',
            'is_active' => 'required'
        ];
    }
}
