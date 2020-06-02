<?php

namespace App\Providers;

use App\Support\AdditionalAttribute\AdditionalAttribute;
use App\Support\Settings\SettingRepository;
use BristolSU\ControlDB\Contracts\Models\DataGroup;
use BristolSU\ControlDB\Contracts\Models\DataPosition;
use BristolSU\ControlDB\Contracts\Models\DataRole;
use BristolSU\ControlDB\Contracts\Models\DataUser;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AdditionalAttributeProvider extends ServiceProvider
{

    public function boot()
    {
        $settingRepository = $this->app->make(SettingRepository::class);
        try {
            foreach($settingRepository->get('additional_attributes.user', []) as $attribute) {
                (app(DataUser::class))::addProperty($attribute['key']);
            }

            foreach($settingRepository->get('additional_attributes.group', []) as $attribute) {
                (app(DataGroup::class))::addProperty($attribute['key']);
            }

            foreach($settingRepository->get('additional_attributes.role', []) as $attribute) {
                (app(DataRole::class))::addProperty($attribute['key']);
            }

            foreach($settingRepository->get('additional_attributes.position', []) as $attribute) {
                (app(DataPosition::class))::addProperty($attribute['key']);
            }

        } catch (\Exception $e) {
            // TODO Handle this exception. This occurs when commands are run but the database isn't migrated so the attribute col doesn't exist
        }

    }

}
