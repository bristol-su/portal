<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Auth\Authentication\Contracts\AuthenticationUserResolver;

class WhoAmIController extends Controller
{

    public function index(AuthenticationUserResolver $authentication)
    {
        $user = $authentication->getUser();
        $controlUser = $user->controlUser();
        $userAsArray = $user->toArray();
        $userAsArray['control'] = $controlUser->toArray();

        return $userAsArray;
    }

}
