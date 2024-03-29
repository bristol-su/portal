<?php

namespace App\Providers;



use App\Actions\SendToIntegromat;
use App\Actions\TagARole;
use App\Actions\TagAGroup;
use App\Console\Commands\ExportRoles\RoleExport;
use App\Filters\Group\PredefinedFilter as PredefinedGroupFilter;
use App\Filters\Role\PredefinedFilter as PredefinedRoleFilter;
use App\Filters\User\PredefinedFilter as PredefinedUserFilter;
use App\Rules\CustomValidator;
use App\Rules\ModuleAlias;
use BristolSU\Support\Action\Facade\ActionManager;
use BristolSU\Support\Filters\Contracts\FilterManager as FilterManagerContract;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->call([$this, 'registerFilters']);

        $this->commands([
            RoleExport::class
        ]);

        Validator::resolver(function($translator, $data, $rules, $messages, $attributes)
        {
            return new CustomValidator($translator, $data, $rules, $messages, $attributes);
        });

        Validator::extend('modulealias', fn ($attribute, $value, $parameters, $validator) => app(ModuleAlias::class)->passes($attribute, $value), app(ModuleAlias::class)->message());

        RateLimiter::for('airtable', function ($job) {
            return Limit::perMinute(5);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });

        ActionManager::registerAction(SendToIntegromat::class, 'Send to Integromat', 'Send the event to Integromat for processing');
        ActionManager::registerAction(TagARole::class, 'Tag a Role', 'Tag a Role with a Tag');
        ActionManager::registerAction(TagAGroup::class, 'Tag a Group', 'Tag a Group with a Tag');

    }

    /**
     * @param FilterManagerContract $filterManager
     */
    public function registerFilters(FilterManagerContract $filterManager)
    {
        // User Filters
        $filterManager->register('predefined_user', PredefinedUserFilter::class);

        // Group Filters
        $filterManager->register('predefined_group', PredefinedGroupFilter::class);

        // Role Filters
        $filterManager->register('predefined_role', PredefinedRoleFilter::class);
    }
}
