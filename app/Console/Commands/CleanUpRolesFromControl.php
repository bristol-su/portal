<?php

namespace App\Console\Commands;

use App\Jobs\ClearRoleIfMissing;
use BristolSU\AirTable\Models\AirtableId;
use Illuminate\Console\Command;

class CleanUpRolesFromControl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'control:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        foreach(AirtableId::where('model_type', 'control_Roles_appTjlOrph4ESz2tw')->get() as $airtableId) {
            ClearRoleIfMissing::dispatch($airtableId);
        }
        // Get all the roles as they exist on AirTable from the airtable ID col.
        // If the model id (role) does not exist, delete it.
        //

        return 0;
    }
}
