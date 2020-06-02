<?php

namespace App\Console\Commands;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\Support\Filters\Contracts\FilterInstance;
use BristolSU\Support\Filters\Contracts\FilterInstanceRepository;
use BristolSU\Support\Filters\Contracts\FilterTester;
use Illuminate\Console\Command;

class CheckFilterInstance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filters:test
                            {resource_id : The ID of the user/group/role}
                            {--filter_instance_id= : The ID of the filter instance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test a single filter instance against a resource';
    /**
     * @var FilterInstanceRepository
     */
    private $filterInstanceRepository;
    /**
     * @var FilterTester
     */
    private $filterTester;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FilterInstanceRepository $filterInstanceRepository, FilterTester $filterTester)
    {
        parent::__construct();
        $this->filterInstanceRepository = $filterInstanceRepository;
        $this->filterTester = $filterTester;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $result = $this->filterTester->evaluate($this->getFilterInstance(), $this->getModel());
        $this->line(sprintf('The filter instance returned %s for ' . $this->getModelString(), ($result?'true':'false')));
    }

    private function getFilterInstance()
    {
        return $this->filterInstanceRepository->getById($this->filterInstanceId());
    }

    private function filterInstanceId()
    {
        return $this->option('filter_instance_id') ?: $this->choice('Which filter should we test?',
            app(FilterInstanceRepository::class)->all()->map(function(FilterInstance $filterInstance) {
                return $filterInstance->id;
            })->toArray()
        );
    }

    private function getModel()
    {
        $id = $this->argument('resource_id');
        $filterInstance = $this->getFilterInstance();
        if($filterInstance->for() === 'user') {
            return app(User::class)->getById($id);
        }
        if($filterInstance->for() === 'group') {
            return app(Group::class)->getById($id);
        }
        if($filterInstance->for() === 'role') {
            return app(Role::class)->getById($id);
        }
    }

    private function getForResourceType($ifUser, $ifGroup, $ifRole)
    {
        $filterInstance = $this->getFilterInstance();
        if($filterInstance->for() === 'user') {
            return $ifUser;
        }
        if($filterInstance->for() === 'group') {
            return $ifGroup;
        }
        if($filterInstance->for() === 'role') {
            return $ifRole;
        }
    }

    private function getModelString()
    {
        $id = $this->argument('resource_id');
        return $this->getForResourceType(
            'user #' . $id,
            'group #' . $id,
            'role #' . $id,
        );
    }
}
