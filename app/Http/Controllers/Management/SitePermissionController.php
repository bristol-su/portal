<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use BristolSU\Support\Permissions\Models\Permission;

class SitePermissionController extends Controller
{

    public function index()
    {
        return view('management.sitepermissions.index');
    }

    public function show(Permission $permission)
    {
        return view('management.sitepermissions.show')->with('permission', $permission);
    }

}
