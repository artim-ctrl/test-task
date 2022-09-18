<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|int|exists:users,id',
            'name' => 'sometimes|required|string|min:10|max:80',
            'article' => 'sometimes|required|string|max:5000',
        ];
    }
}
