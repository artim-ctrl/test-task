<?php

namespace App\Http\Requests\Article;

use App\Http\Requests\BaseRequest;

class StoreArticleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|int|exists:users,id',
            'name' => 'required|string|min:10|max:80',
            'article' => 'required|string|max:5000',
        ];
    }
}
