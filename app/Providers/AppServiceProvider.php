<?php

namespace App\Providers;



use App\Actions\SendToIntegromat;
use App\Actions\TagARole;
use App\Support\Settings\Setting;
use App\Support\Settings\SettingRepository;
use BristolSU\Support\Action\Facade\ActionManager;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::withoutCookieSerialization();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SettingRepository::class, Setting::class);

        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });

        ActionManager::registerAction(SendToIntegromat::class, 'Send to Integromat', 'Send the event to Integromat for processing');
        ActionManager::registerAction(TagARole::class, 'Tag a Role', 'Tag a Role with a Tag');

    }
}
