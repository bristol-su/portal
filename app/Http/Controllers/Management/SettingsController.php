<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{

    public function index()
    {
        return view('management.settings.settings');
    }

}
