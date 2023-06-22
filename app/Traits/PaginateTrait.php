<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait PaginateTrait
{
    public function paginate($items, $perPage, $page = 1)
    {
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );
    }
}
