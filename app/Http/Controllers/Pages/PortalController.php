<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use App\Support\DrawerTag;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Support\Facades\Response;

class PortalController extends Controller
{

    public function portal()
    {
        return Response::redirectTo('p');
    }

    public function participant(Authentication $authentication)
    {
        if($authentication->getUser() === null && $authentication->getGroup() === null && $authentication->getRole() === null) {
            return view('pages.portal.dashboard')->with([
                'drawerTag' => DrawerTag::PORTAL
            ]);
        }
        return view('pages.portal.portal')->with([
            'drawerTag' => DrawerTag::PORTAL
        ]);
    }

    public function administrator(Authentication $authentication)
    {
        return view('pages.portal.portal')->with([
            'drawerTag' => DrawerTag::PORTAL
        ]);
    }

}

