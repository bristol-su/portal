<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;

class ConnectorController extends Controller
{

    public function index()
    {
        return view('management.connector.index');
    }

}
