<?php

namespace App\Http\Requests\Article;

use App\Http\Requests\BaseRequest;

class UpdateArticleRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'name' => 'sometimes|required|min:10|max:80',
            'article' => 'sometimes|required|max:5000',
        ];
    }
}
