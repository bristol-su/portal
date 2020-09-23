<?php


namespace App\Providers;


use App\Http\Views\InjectSettings;
use Illuminate\Support\Facades\View;
use Illuminate\View\ViewServiceProvider as ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    public function boot()
    {
        View::composer('bristolsu::base', InjectSettings::class);
    }

}
