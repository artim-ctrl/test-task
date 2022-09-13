<?php

namespace App\Http\Requests\Video;

use App\Http\Requests\BaseRequest;

class UpdateVideoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'name' => 'sometimes|required|min:10|max:80',
            'url' => 'sometimes|required|max:255',
        ];
    }
}
