<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Paginate an array of items given
     *
     * @param $items
     * @return mixed
     */
    public function paginate($items)
    {
        $perPage = request()->input('per_page', 10);
        $page = request()->input('page', 1);

        $slicedItems = collect($items)->forPage($page, $perPage)->values();

        return $this->paginationResponse($slicedItems, count($items));
    }

    public function paginationResponse($items, $count)
    {
        $perPage = request()->input('per_page', 10);
        $page = request()->input('page', 1);

        return (new LengthAwarePaginator(
            $items,
            $count,
            $perPage,
            $page,
            ['path' => url(request()->path())]
        ))->appends('per_page', $perPage);
    }
}
