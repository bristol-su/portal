<?php

namespace App\Jobs;

use _PHPStan_76800bfb5\Composer\XdebugHandler\Process;
use BristolSU\AirTable\Models\AirtableId;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClearRoleIfMissing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private AirtableId $airtableId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AirtableId $airtableId)
    {

        $this->airtableId = $airtableId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            app(Role::class)->getById((int) $this->airtableId->modelId());
        } catch (ModelNotFoundException $e) {
            \Log::info('Airtable ID ' . $this->airtableId->airtableId() . ' should be deleted');
        }
        //
    }
}
