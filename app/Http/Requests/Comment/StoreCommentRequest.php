<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\BaseRequest;

class StoreCommentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|int|exists:users,id',
            'entity' => 'bail|required|string|max:10|in:video,article',
            'entity_id' => 'required|int|exists:' . $this->getTableEntity() . ',id',
            'comment' => 'required|string|min:5|max:1000',
        ];
    }

    protected function getTableEntity(): ?string
    {
        return match ($this->get('entity')) {
            'video' => 'videos',
            'article' => 'articles',
            default => null,
        };
    }
}
