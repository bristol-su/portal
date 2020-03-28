<?php


namespace App\Providers;


use App\Support\UnionCloud\DataUserRepository;
use BristolSU\ControlDB\Contracts\Repositories\DataUser;
use BristolSU\ControlDB\ControlDBServiceProvider;

class ControlServiceProvider extends ControlDBServiceProvider
{

    public function register()
    {
        parent::register();
    }

    public function boot()
    {
        parent::boot();
        if(config('app.use_unioncloud', false)) {
            $this->app->bind(DataUser::class, DataUserRepository::class);
        }
    }
}
