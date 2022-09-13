<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class StoreUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:10|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'role' => 'sometimes|required|string|max:10|in:admin,user',
            'password' => 'required|string|min:8|max:12',
        ];
    }
}
