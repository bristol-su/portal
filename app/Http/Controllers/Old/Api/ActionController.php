<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Action\Contracts\ActionRepository;
use BristolSU\Support\Action\Contracts\RegisteredAction;

/**
 * Manage actions registered with the portal
 */
class ActionController extends Controller
{

    /**
     * Get all actions
     *
     * @param ActionRepository $actionRepository Repository to retrieve actions from
     * @return RegisteredAction[]
     */
    public function index(ActionRepository $actionRepository)
    {
        return $actionRepository->all();
    }
}
