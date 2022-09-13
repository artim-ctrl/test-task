<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class IndexUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'search.name' => 'sometimes|required|string',
            'search.email' => 'sometimes|required|string',
            'search.role' => 'sometimes|required|string',
            'limit' => 'sometimes|required|int',
            'page' => 'sometimes|required|int',
        ];
    }
}
