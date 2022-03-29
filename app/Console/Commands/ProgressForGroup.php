<?php

namespace App\Console\Commands;

use BristolSU\Support\ActivityInstance\ActivityInstance;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository as ModuleInstanceRepository;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use BristolSU\Support\Progress\Jobs\UpdateProgressForGivenActivityInstances;
use Illuminate\Console\Command;

class ProgressForGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'progress:group {actinstid : The ID of the module instance to restore}';

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
        $actInstances = [ActivityInstance::findOrFail(3249)];
        UpdateProgressForGivenActivityInstances::dispatch($actInstances, 'airtable2022');
        return 1;
    }
}
