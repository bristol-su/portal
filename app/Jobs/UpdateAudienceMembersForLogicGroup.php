<?php

namespace App\Jobs;

use BristolSU\Support\Logic\Contracts\Audience\AudienceMemberFactory;
use BristolSU\Support\Logic\Contracts\Audience\LogicAudience;
use BristolSU\Support\Logic\Logic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAudienceMembersForLogicGroup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Logic
     */
    private $logic;

    public function __construct(Logic $logic)
    {
        $this->logic = $logic;
    }

    public function handle(LogicAudience $logicAudience)
    {
        $logicAudience->audience($this->logic);
    }

}
