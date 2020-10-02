<?php

namespace App\Providers;

use App\Settings\Appearance\AppearanceCategory;
use App\Settings\Appearance\Messaging\Footer as FooterText;
use App\Settings\Appearance\Messaging\MessagingGroup;
use App\Settings\Appearance\Messaging\SiteTitle;
use BristolSU\Support\Settings\Definition\DefinitionStore;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $register = $this->app->make(DefinitionStore::class);
        $register->register(FooterText::class, AppearanceCategory::class, MessagingGroup::class);
        $register->register(SiteTitle::class, AppearanceCategory::class, MessagingGroup::class);
    }

}
