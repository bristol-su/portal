<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Settings\Definition\SettingStore;
use BristolSU\Support\Settings\Definition\UserSetting;
use BristolSU\Support\Settings\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SettingController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param string $key
     * @param SettingRepository $settingRepository
     * @param SettingStore $settingStore
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(string $key, SettingRepository $settingRepository, SettingStore $settingStore)
    {
        $setting = $settingStore->getSetting($key);
        if($setting instanceof UserSetting) {
            $value = $settingRepository->getUserValue($key);
        } else {
            $value = $settingRepository->getGlobalValue($key);
        }
        return Response::make($value, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $key, SettingRepository $settingRepository, SettingStore $settingStore)
    {
        $request->validate([
            'value' => 'required'
        ]);
        $setting = $settingStore->getSetting($key);
        if($setting instanceof UserSetting) {
            $settingRepository->setForUser($key, $request->input('value'));
        } else {
            $settingRepository->setGlobal($key, $request->input('value'));
        }
        return Response::make('', 201);
    }
}
