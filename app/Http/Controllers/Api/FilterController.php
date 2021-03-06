<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use BristolSU\Support\Filters\Contracts\FilterRepository;
use BristolSU\Support\Filters\Contracts\Filters\Filter;

class FilterController extends Controller
{

    public function index(FilterRepository $filterRepository)
    {
        return collect($filterRepository->getAll())->map(function(Filter $filter) {
            return $filter->toArray();
        });
    }

}
