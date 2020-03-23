<?php

namespace App\Http\Controllers\Api\Relationships;

use App\Http\Controllers\Controller;
use BristolSU\Support\Action\ActionInstance;

class ActionInstanceActionInstanceFieldController extends Controller
{

    public function index(ActionInstance $actionInstance)
    {
        return $actionInstance->actionInstanceFields;
    }

}
