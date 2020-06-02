<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class ControlController extends Controller
{

    public function index()
    {
//        $this->authorize('access-control');

        return view('portal.control');
    }

}
