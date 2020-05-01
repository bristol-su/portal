<?php

namespace App\Console\Commands;

use App\Jobs\UpdateAudienceMembersForLogicGroup;
use BristolSU\Support\Logic\Contracts\LogicRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateAudienceMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audience:cache
                            {--sync : Run the job in sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled unioncloud commands';

    public function handle(LogicRepository $logicRepository)
    {
        foreach($logicRepository->all() as $logic) {
            $this->info('Caching logic group #' . $logic->id);
            Log::info('Caching logic group #' . $logic->id);
            if($this->option('sync')) {
                dispatch_now(new UpdateAudienceMembersForLogicGroup($logic));
            } else {
                dispatch(new UpdateAudienceMembersForLogicGroup($logic));
            }
        }
    }


}
