<?php

namespace App\Console\Commands;

use BristolSU\AirTable\AirTable;
use BristolSU\AirTable\Models\AirtableId;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteDuplicateRoleRows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'control:duplicate-roles';

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
        $airtable = app(AirTable::class);
        $airtable->setApiKey(config('control.export.bristol-control-roles.apiKey'));
        $airtable->setBaseId(config('control.export.bristol-control-roles.baseId'));
        $airtable->setTableName(config('control.export.bristol-control-roles.tableName'));

        $deleted = 0;
        $airtableIds = AirtableId::where(
            'model_type',
            sprintf('control_%s_%s', config('control.export.bristol-control-roles.tableName'), config('control.export.bristol-control-roles.baseId'))
        )->groupBy('model_id')->having(DB::raw('count(model_id)'), '>', 1)->get([DB::raw('count(model_id)'), 'model_id']);

        foreach($airtableIds as $airtableId) {
            $modelId = $airtableId->modelId();
            $airtableIdToRemove = AirtableId::where('model_id', $modelId)
                ->where(
                    'model_type',
                    sprintf('control_%s_%s', config('control.export.bristol-control-roles.tableName'), config('control.export.bristol-control-roles.baseId'))
                )
                ->get();
            if($airtableIdToRemove && $airtableIdToRemove->count() > 1) {
//                $airtable->deleteRows([$airtableIdToRemove->first()->airtableId()]);
//                $airtableIdToRemove->first()->delete();
                $deleted++;
            }

        }

        dd($deleted);

        return 0;
    }
}
