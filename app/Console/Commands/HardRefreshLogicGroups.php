<?php

namespace App\Console\Commands;

use BristolSU\Support\Logic\DatabaseDecorator\LogicResult;
use BristolSU\Support\Logic\Jobs\CacheLogic;
use BristolSU\Support\Logic\Logic;
use Illuminate\Console\Command;

class HardRefreshLogicGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logic:hard-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hard refresh logic groups';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $logics = Logic::where('id', '>=', 57)->get();
        $this->line(sprintf('Dispatching %u logics', $logics->count()));

        foreach($logics as $logic) {
            $this->line(sprintf('Handling logic #%u with %u current results', $logic->id, LogicResult::where('logic_id', $logic->id)->count()));
            LogicResult::where('logic_id', $logic->id)->delete();
            $this->line(sprintf('Deleted results for #%u with %u current results', $logic->id, LogicResult::where('logic_id', $logic->id)->count()));
            CacheLogic::dispatch($logic);
        }

        return static::SUCCESS;
    }

}
