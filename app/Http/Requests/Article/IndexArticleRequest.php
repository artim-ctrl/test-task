<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class IndexArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search.user_id' => 'sometimes|required|int',
            'search.name' => 'sometimes|required|string',
            'search.article' => 'sometimes|required|string',
            'limit' => 'sometimes|required|int',
            'page' => 'sometimes|required|int',
        ];
    }
}
