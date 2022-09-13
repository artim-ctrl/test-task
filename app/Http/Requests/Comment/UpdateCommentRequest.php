<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\BaseRequest;

class UpdateCommentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'entity' => 'sometimes|bail|required|string|max:10|in:video,article',
            'entity_id' => 'sometimes|required|int|exists:' . $this->getTableEntity() . ',id',
            'comment' => 'sometimes|required|string|min:5|max:1000',
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
