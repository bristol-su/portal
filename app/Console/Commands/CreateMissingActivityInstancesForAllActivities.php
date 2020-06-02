<?php

namespace App\Console\Commands;

use BristolSU\Support\Activity\Contracts\Repository;
use Illuminate\Console\Command;

class CreateMissingActivityInstancesForAllActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activityinstance:activity:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all activity instances for all activities';
    /**
     * @var Repository
     */
    private $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Repository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach($this->repository->all() as $activity) {
            dispatch(new \App\Jobs\CreateMissingActivityInstances($activity));
        }
    }
}
