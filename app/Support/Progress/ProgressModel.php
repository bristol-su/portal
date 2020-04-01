<?php

namespace App\Support\Progress;

use BristolSU\Support\ActivityInstance\ActivityInstance;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\Evaluation;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstance;
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

    private $moduleInstances;


    public function setActivityInstance(ActivityInstance $activityInstance)
    {
        $this->activityInstance = $activityInstance;
    }

    public function setEvaluation(ModuleInstance $moduleInstance, Evaluation $evaluation)
    {
        $this->moduleInstances[$moduleInstance->id()] = $moduleInstance;
        $this->evaluations[$moduleInstance->id()] = $evaluation;
    }

    private function evaluation($moduleInstanceId)
    {
        return $this->evaluations[$moduleInstanceId];
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $activityInstance =  $this->activityInstance->toArray();
        $activityInstance['module_instances'] = collect($this->moduleInstances)->map(function(ModuleInstance $moduleInstance) {
            $module = $moduleInstance->toArray();
            $module['evaluation'] = $this->evaluation($moduleInstance->id())->toArray();
            return $module;
        })->values()->toArray();
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
