<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\UserRelation\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'name' => $this->name,
            'article' => $this->article,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
