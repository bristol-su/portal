<?php

namespace App\Http\Controllers\Api\Relationships;

use App\Http\Controllers\Controller;
use BristolSU\Support\Action\ActionInstance;

class ActionInstanceActionInstanceHistoryController extends Controller
{

    public function index(ActionInstance $actionInstance)
    {
        return $actionInstance->history;
    }

}
