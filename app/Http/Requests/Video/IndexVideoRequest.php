<?php

namespace App\Http\Requests\Video;

use App\Http\Requests\BaseRequest;

class IndexVideoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'search.user_id' => 'sometimes|required|int',
            'search.name' => 'sometimes|required|string',
            'limit' => 'sometimes|required|int',
            'page' => 'sometimes|required|int',
        ];
    }
}
