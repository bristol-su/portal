<?php

namespace App\Console\Commands;

use App\Jobs\UpdateAudienceMembersForLogicGroup;
use BristolSU\Support\Logic\Contracts\LogicRepository;
use Illuminate\Console\Command;

class UpdateAudienceMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audience:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled unioncloud commands';

    public function handle(LogicRepository $logicRepository)
    {
        foreach($logicRepository->all() as $logic) {
            dispatch(new UpdateAudienceMembersForLogicGroup($logic));
        }
    }


}
