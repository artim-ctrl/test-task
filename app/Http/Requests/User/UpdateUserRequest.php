<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|min:10|max:50',
            'email' => 'sometimes|required|email|max:50|unique:users,email',
            'role' => 'sometimes|required|string|max:10|in:admin,user',
            'password' => 'sometimes|required|string|min:8|max:12',
        ];
    }
}
