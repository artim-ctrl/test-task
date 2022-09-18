<?php

namespace App\Http\Controllers\Traits;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

trait ResourceTrait
{
    protected function canManage(Video|Article|Comment $entity): bool
    {
        return Auth::user()->isAdmin() || $entity->user_id === auth()->id();
    }
}
