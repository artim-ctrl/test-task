<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

trait ResourceTrait
{
    protected function getPaginationInfo(LengthAwarePaginator $paginate): array
    {
        return [
            'current_page' => $paginate->currentPage(),
            'per_page' => $paginate->perPage(),
            'last_page' => $paginate->lastPage(),
            'total' => $paginate->total(),
        ];
    }

    public function checkOwnerOrAdmin($entity): bool
    {
        return Auth::user()->isAdmin() || $entity->user_id === Auth::user()->id;
    }
}
