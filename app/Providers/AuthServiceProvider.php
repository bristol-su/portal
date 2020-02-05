<?php

namespace App\Providers;

use App\Support\Auth\UserProvider;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\Support\Permissions\Facade\Permission;
use BristolSU\Support\User\Contracts\UserRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Permission::registerSitePermission('view-management', 'Access Settings', 'Can access the settings page');
        Permission::registerSitePermission('index-activities','See all activities','Can see a list of all activities on the settings page');
        Permission::registerSitePermission('show-activities','View an activities','View an activity on the settings page');
        Permission::registerSitePermission('create-activities','Create an activity','Can create an activity');
    }

    public function register()
    {
        $this->app->rebinding('request', function ($app, $request) {
            $request->setUserResolver(function () use ($app) {
                return app(UserAuthentication::class)->getUser();
            });
        });

        Auth::provider('database-user-provider', function(Container $app, array $config) {
            return new UserProvider($app->make(UserRepository::class));
        });
    }
}
