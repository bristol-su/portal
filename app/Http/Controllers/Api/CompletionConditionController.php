<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Completion\Contracts\CompletionConditionRepository;

class CompletionConditionController extends Controller
{

    public function show(string $moduleAlias, string $completionConditionAlias, CompletionConditionRepository $completionConditionRepository)
    {
        return $completionConditionRepository->getByAlias($moduleAlias, $completionConditionAlias);
    }

    public function index(string $moduleAlias, CompletionConditionRepository $completionConditionRepository)
    {
        return collect($completionConditionRepository->getAllForModule($moduleAlias));
    }

}
