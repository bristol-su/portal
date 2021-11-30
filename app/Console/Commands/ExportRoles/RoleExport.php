<?php

namespace App\Console\Commands\ExportRoles;

use App\Jobs\ExportRoles;
use BristolSU\ControlDB\Export\Exporter;
use BristolSU\ControlDB\Contracts\Models\Role;
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
        $roles = Audience::getRolesInLogicGroup($logicRepository->getById(config('control.logicId')));

        if($roles->count() === 0) {
            $this->error('No roles were found');
        }

        foreach($roles->chunk(10) as $processingRoles) {
            ExportRoles::dispatch($processingRoles);
        }
        $this->info('Export complete');

    }
}
