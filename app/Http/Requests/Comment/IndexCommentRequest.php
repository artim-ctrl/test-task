<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\BaseRequest;

class IndexCommentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'search.user_id' => 'sometimes|required|int',
            'search.entity' => 'sometimes|required|string',
            'search.entity_id' => 'sometimes|required|int',
            'search.comment' => 'sometimes|required|string',
            'limit' => 'sometimes|required|int',
            'page' => 'sometimes|required|int',
        ];
    }
}
