<?php

namespace App\Jobs;

use _PHPStan_76800bfb5\Composer\XdebugHandler\Process;
use BristolSU\AirTable\AirTable;
use BristolSU\AirTable\Models\AirtableId;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteAirTableRow implements ShouldQueue
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
        $at = app(AirTable::class);
        $at->setApiKey(config('control.export.bristol-control-roles.apiKey'));
        $at->setBaseId(config('control.export.bristol-control-roles.baseId'));
        $at->setTableName(config('control.export.bristol-control-roles.tableName'));
        $at->deleteRows([$this->airtableId->airtableId()]);
    }
}
