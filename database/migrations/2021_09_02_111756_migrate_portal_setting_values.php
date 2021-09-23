<?php

use App\Settings\Appearance\Messaging\Footer;
use App\Settings\Appearance\Messaging\LandingPageTitle;
use BristolSU\Support\Settings\Saved\SavedSettingModel;
use Illuminate\Database\Migrations\Migration;

class MigratePortalSettingValues extends Migration
{

    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        foreach ($this->getKeysToChange() as $original => $new) {
            SavedSettingModel::key($original)->update(['key' => $new]);
        }
        SavedSettingModel::whereIn('key', [
            'welcome.fillInRegInformation',
            'welcome.messages.title',
            'welcome.messages.subtitle',
            'welcome.attributes',
            'thirdPartyAuthentication.providers'
        ])->delete();
    }

    protected function getKeysToChange(): array
    {
        return [
            'pageText.footer' => Footer::getKey(),
            'pageText.landing' => LandingPageTitle::getKey(),
        ];
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down()
    {
        foreach ($this->getKeysToChange() as $original => $new) {
            SavedSettingModel::key($new)->update(['key' => $original]);
        }
    }
}
