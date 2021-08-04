<?php

namespace App\Providers;

use BristolSU\Support\Permissions\Facade\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        Permission::registerSitePermission('access-control','Access Control','Can access the user management system, Control');
        Permission::registerSitePermission('access-helpdesk','Access Helpdesk','Can view and submit the helpdesk widget');
        Permission::registerSitePermission('viewVaporUI','View Vapor UI','Can view the Vapor UI page');
    }

    public function register()
    {
    }
}
