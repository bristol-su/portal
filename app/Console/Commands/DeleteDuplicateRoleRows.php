<?php

namespace App\Console\Commands;

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
        $airtableIds = AirtableId::where(
            'model_type',
            sprintf('control_%s_%s', config('control.export.bristol-control-roles.tableName'), config('control.export.bristol-control-roles.baseId'))
        )->groupBy(DB::raw('count(model_id)'))->having(DB::raw('count(model_id)'), '>', 1)->get([DB::raw('count(model_id)'), 'model_id']);

        dd($airtableIds);

        return 0;
    }
}
