<?php

namespace App\Http\Requests\Video;

use App\Http\Requests\BaseRequest;

class StoreVideoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|int|exists:users,id',
            'name' => 'required|string|min:10|max:80',
            'url' => 'required|string|url|max:255',
        ];
    }
}
