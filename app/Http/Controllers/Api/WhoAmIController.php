<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\User\Contracts\UserAuthentication;

class WhoAmIController extends Controller
{

    public function index(UserAuthentication $authentication)
    {
        return $authentication->getUser();
    }

}
