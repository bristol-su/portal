<?php

namespace App\Console\Commands;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\ControlDB\Export\Exporter;
use BristolSU\ControlDB\Export\RunExport;
use BristolSU\Support\Filters\Contracts\FilterInstance;
use BristolSU\Support\Filters\Contracts\FilterInstanceRepository;
use BristolSU\Support\Filters\Contracts\FilterTester;
use BristolSU\Support\Logic\Audience\Audience;
use BristolSU\Support\Logic\Contracts\LogicRepository;
use Illuminate\Console\Command;

class RoleExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all roles';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle(LogicRepository $logicRepository)
    {
        $roles = Audience::getRolesInLogicGroup($logicRepository->getById(config('control.logic_id')));

        if($roles->count() === 0) {
            $this->error('No roles were found');
        }

        foreach($roles->chunk(200) as $processingRoles) {
            Exporter::driver('airtable')->export($processingRoles);
        }
        $this->info('Export complete');

    }
}
