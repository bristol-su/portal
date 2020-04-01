<?php

namespace App\Support\Progress;

use BristolSU\Support\ActivityInstance\ActivityInstance;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\Evaluation;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class ProgressModel implements Arrayable, Jsonable
{

    /**
     * @var ActivityInstance
     */
    private $activityInstance;

    /**
     * @var array|
     */
    private $evaluations;


    public function setActivityInstance(ActivityInstance $activityInstance)
    {
        $this->activityInstance = $activityInstance;
    }

    public function setEvaluation(int $moduleInstanceId, Evaluation $evaluation)
    {
        $this->evaluations[$moduleInstanceId] = $evaluation;
    }

    /**
     * @return Collection
     */
    private function evaluations()
    {
        return collect($this->evaluations);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $activityInstance =  $this->activityInstance->toArray();
        $activityInstance['module_instances'] = $this->activityInstance->moduleInstances->map(function(ModuleInstance $moduleInstance) {
            $module = $moduleInstance->toArray();
            $module['evaluation'] = $this->evaluations()->get($moduleInstance->id());
            return $module;
        });
        return $activityInstance;
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
