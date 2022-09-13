<?php

namespace App\Http\Requests\Video;

use App\Http\Requests\BaseRequest;

class UpdateVideoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|int|exists:users,id',
            'name' => 'sometimes|required|string|min:10|max:80',
            'url' => 'sometimes|required|string|max:255',
        ];
    }
}
