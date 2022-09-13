<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
}
