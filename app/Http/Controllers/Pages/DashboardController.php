<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Support\DrawerTag;

class DashboardController extends Controller
{

    public function index()
    {
        return view('pages.portal.dashboard')
            ->with('drawerTag', DrawerTag::PORTAL);
    }

}
