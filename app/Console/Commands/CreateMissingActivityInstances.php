<?php

namespace App\Console\Commands;

use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\Logic\Contracts\Audience\LogicAudience;
use Illuminate\Console\Command;

class CreateMissingActivityInstances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activityinstance:create
                            {activity_id : ID of the activity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all missing activity instances for an activity';

    private $activity;
    /**
     * @var LogicAudience
     */
    private $logicAudience;
    /**
     * @var DefaultActivityInstanceGenerator
     */
    private $generator;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LogicAudience $logicAudience, DefaultActivityInstanceGenerator $generator)
    {
        parent::__construct();
        $this->logicAudience = $logicAudience;
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch_now(new \App\Jobs\CreateMissingActivityInstances($this->activity()));
    }

    private function activity(): Activity
    {
        if(!$this->activity) {
            $this->activity = app(Repository::class)->getById($this->argument('activity_id'));
        }
        return $this->activity;
    }
}
