<?php

namespace App\Console\Commands;

use BristolSU\ControlDB\Contracts\Repositories\DataUser;
use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\Support\Permissions\Models\ModelPermission;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:promote {user? : The ID of the user. Leave blank to choose.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an administrator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(($user = $this->argument('user')) === null) {
            $users = app(User::class)->all();
            if($users->count() === 0) {
                $this->error('No users were found. Please register first!');
                return 1;
            }
            $user = app(DataUser::class)->getWhere(['email' => $this->choice('Which user do you want to make an admin?',
                $users->map(function(\BristolSU\ControlDB\Contracts\Models\User $user) {
                    return $user->data()->email();
                })->toArray(), $users->first()->id)])->id();
        }

        try {
            $userModel = app(User::class)->getById($user);
        } catch (ModelNotFoundException $e) {
            $this->error(sprintf('User %s not found', $user));
            return 1;
        }

        $this->line('Giving admin permissions to user ' . $userModel->data()->email());
        ModelPermission::updateOrCreate([
            'model' => 'user',
            'model_id' => $user,
            'ability' => 'view-management'
        ], ['result' => true]);

        ModelPermission::updateOrCreate([
            'model' => 'user',
            'model_id' => $user,
            'ability' => 'access-control'
        ], ['result' => true]);

        $this->info('Permissions updated!');

    }
}
