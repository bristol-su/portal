<?php

namespace App\Support\Progress;

use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\ActivityInstance;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use BristolSU\Support\Logic\Contracts\Audience\LogicAudience;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstance;
use BristolSU\Support\ModuleInstance\Facade\ModuleInstanceEvaluator;
use Illuminate\Support\Facades\Cache;

class Progress
{

    /**
     * @var ActivityInstanceRepository
     */
    private $activityInstanceRepository;

    public function __construct(ActivityInstanceRepository $activityInstanceRepository)
    {
        $this->activityInstanceRepository = $activityInstanceRepository;
    }

    public function forActivity(Activity $activity)
    {
        return $this->activityInstanceRepository->allForActivity($activity->id)->map(function(ActivityInstance $activityInstance) {
            return $this->getProgress($activityInstance);
        });
    }

    public function updateProgressInCache(ActivityInstance $activityInstance)
    {
        Cache::forget($this->getKey($activityInstance));
        Cache::put($this->getKey($activityInstance),
            $this->generateProgress($activityInstance), 86400);
    }

    public function getProgress(ActivityInstance $activityInstance)
    {
        return Cache::remember($this->getKey($activityInstance), 86400, function() use ($activityInstance) {
            return $this->generateProgress($activityInstance);
        });
    }

    private function generateProgress(ActivityInstance $activityInstance): ProgressModel
    {
        $progress = new ProgressModel();
        $progress->setActivityInstance($activityInstance);
        $activityInstance->moduleInstances->map(function(ModuleInstance $moduleInstance) use ($activityInstance, $progress) {
            $progress->setEvaluation($moduleInstance->id(), ModuleInstanceEvaluator::evaluateResource($activityInstance, $moduleInstance));
        });
        return $progress;
    }

    protected function getKey(ActivityInstance $activityInstance)
    {
        return static::class . ':' . $activityInstance->id;
    }
}
