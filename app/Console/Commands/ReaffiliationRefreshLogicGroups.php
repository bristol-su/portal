<?php

namespace App\Console\Commands;

use BristolSU\Support\Logic\DatabaseDecorator\LogicResult;
use BristolSU\Support\Logic\Jobs\CacheLogic;
use BristolSU\Support\Logic\Logic;
use Illuminate\Console\Command;

class ReaffiliationRefreshLogicGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logic:reaffiliation';

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
            $this->line(sprintf('Handling logic #%u', $logic->id));
            CacheLogic::dispatch($logic)->delay(100);
        }

        return static::SUCCESS;
    }

}
