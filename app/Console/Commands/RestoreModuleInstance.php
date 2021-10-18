<?php

namespace App\Console\Commands;

use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository as ModuleInstanceRepository;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Illuminate\Console\Command;

class RestoreModuleInstance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:restore {module-instance : The ID of the module instance to restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the given module instance by ID';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleInstance = ModuleInstance::onlyTrashed()->findOrFail($this->argument('module-instance'));

        if($moduleInstance->activity()->exists()) {
            $moduleInstance->restore();
            $this->output->success('Module instance restored');
            return 0;
        }

        $this->output->error('The activity has not been restored, therefore the module cannot be restored');
        if($this->output->confirm('Would you like to restore the activity?')) {
            $this->call(RestoreActivity::class, ['activity' => $moduleInstance->activity_id]);
            return 0;
        }
        $this->output->error(sprintf('Please restore the activity before trying again. You may do this by running activity:restore %u', $moduleInstance->activity_id));
        return 1;
    }
}
