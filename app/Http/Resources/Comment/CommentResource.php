<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\UserRelation\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->user),
            'entity' => $this->entity,
            'article' => $this->when($this->entity === 'article', $this->article),
            'video' => $this->when($this->entity === 'video', $this->video),
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
