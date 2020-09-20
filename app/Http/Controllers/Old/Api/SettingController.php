<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\Settings\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index(SettingRepository $settingRepository)
    {
        return $settingRepository->all();
    }

    public function update($key, Request $request, SettingRepository $settingRepository)
    {
        $settingRepository->set($key, $request->input('value'));
        return [
            'key' => $key, 'value' => $settingRepository->get($key)
        ];
    }

    public function show($key, Request $request, SettingRepository $settingRepository)
    {
        return [
            'key' => $key, 'value' => $settingRepository->get($key, $request->input('default'))
        ];
    }

}
