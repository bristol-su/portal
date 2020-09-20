<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;

class ManagementController extends Controller
{

    public function index()
    {
        return view('management.management');
    }

}
