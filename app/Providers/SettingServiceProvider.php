<?php

namespace App\Providers;

use App\Settings\Appearance\AppearanceCategory;
use App\Settings\Appearance\Messaging\Footer;
use App\Settings\Appearance\Messaging\LandingPageTitle;
use App\Settings\Appearance\Messaging\MessagingGroup;
use App\Settings\Appearance\Messaging\SiteTitle;
use BristolSU\Support\Settings\Concerns\RegistersSettings;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    use RegistersSettings;

    public function boot()
    {
        $this->registerSettings()
            ->category(new AppearanceCategory())
            ->group(new MessagingGroup())
            ->registerSetting(new SiteTitle())
            ->registerSetting(new Footer())
            ->registerSetting(new LandingPageTitle());
    }

}
