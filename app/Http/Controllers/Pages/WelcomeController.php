<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{

    public function welcome()
    {
        if(siteSetting('welcome.fillInRegInformation', true)) {
            return view('portal.welcome');
        }
        return redirect()->route('portal');
    }

}
