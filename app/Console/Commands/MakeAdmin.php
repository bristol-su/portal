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
        if(($userId = $this->argument('user')) === null) {
            $users = app(User::class)->all();
            if($users->count() === 0) {
                $this->error('No users were found. Please register first!');
                return 1;
            }

            $email = $this->anticipate('What is the email of the user to make an admin?', function($input) use ($users) {
                return $users->map(function(\BristolSU\ControlDB\Contracts\Models\User $user) {
                    return $user->data()->email();
                })->values()->take(5)->toArray();
            });

            $user = app(DataUser::class)->getWhere(['email' => $email])->user();
            if($user === null) {
                $this->error('User not found');
                return 1;
            }
        } else {
            try {
                $user = app(User::class)->getById($userId);
            } catch (ModelNotFoundException $e) {
                $this->error(sprintf('User %s not found', $userId));
                return 1;
            }
        }




        $this->line('Giving admin permissions to user ' . $user->data()->email());
        ModelPermission::updateOrCreate([
            'model' => 'user',
            'model_id' => $user->id(),
            'ability' => 'view-management'
        ], ['result' => true]);

        ModelPermission::updateOrCreate([
            'model' => 'user',
            'model_id' => $user->id(),
            'ability' => 'access-control'
        ], ['result' => true]);

        $this->info('Permissions updated!');

    }
}
