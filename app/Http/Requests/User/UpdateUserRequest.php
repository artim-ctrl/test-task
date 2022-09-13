<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UpdateUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|min:10|max:50',
            'email' => 'sometimes|required|email|max:50|unique:users,email',
            'role' => 'sometimes|required|max:10|in:admin,user',
            'password' => 'sometimes|required|min:8|max:12',
        ];
    }
}
