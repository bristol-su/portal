<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;

class LandingController extends Controller
{

    public function index()
    {
        return view('portal.landing');
    }

}

