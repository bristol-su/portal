<?php

namespace App\Support;

use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ActivityInstanceEvaluator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;

class ActivityEvaluator
{

    public function evaluate(Activity $activity): array
    {
        if($activity->activity_for === 'role') {
            $resource = app(Authentication::class)->getRole();
        } else if($activity->activity_for === 'group') {
            $resource = app(Authentication::class)->getGroup();
        } else {
            $resource = app(Authentication::class)->getUser();
        }
        if($resource === null) {
            throw new AuthorizationException(sprintf('You must be logged into the correct resource type (%s)', $activity->activity_for));
        }

        $activityInstance = app(DefaultActivityInstanceGenerator::class)->generate($activity, $activity->activity_for, (string) $resource->id());

        $evaluations = collect(app(ActivityInstanceEvaluator::class)->evaluateResource($activityInstance));
        $percentage = 0;
        $complete = true;
        $moduleCount = 0;
        $completeCount = 0;

        foreach($evaluations as $evaluation) {
            if($evaluation->mandatory()) {
                $moduleCount++;
                $percentage += $evaluation->percentage();
                if(!$evaluation->complete()) {
                    $complete = false;
                } else {
                    $completeCount++;
                }
            }
        }

        return [
            'evaluations' => $evaluations,
            'totalCount' => $moduleCount,
            'completeCount' => $completeCount,
            'complete' => $complete,
            'percentage' => ($moduleCount > 0 ? ($percentage / $moduleCount) : 0)
        ];
    }

    public function evaluateMany(Collection $activities): Collection
    {
        return $activities->mapWithKeys(fn($activity) => [$activity->id => $this->evaluate($activity)]);
    }

}
