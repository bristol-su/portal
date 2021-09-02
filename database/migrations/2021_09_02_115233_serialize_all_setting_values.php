<?php

use App\Settings\Appearance\Messaging\Footer;
use App\Settings\Appearance\Messaging\LandingPageTitle;
use BristolSU\Support\Settings\Saved\SavedSettingModel;
use Illuminate\Database\Migrations\Migration;

class SerializeAllSettingValues extends Migration
{

    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        foreach(SavedSettingModel::all() as $setting) {
            $setting->value = serialize($setting->getSettingValue());
            $setting->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down()
    {
        foreach(SavedSettingModel::all() as $setting) {
            $setting->value = unserialize($setting->getSettingValue());
            $setting->save();
        }
    }
}
