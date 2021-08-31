<?php

namespace App\Http\View\Sidebar;

use App\Http\Middleware\MarkAsManagement;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepository;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceResolver;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ModuleInstanceEvaluator;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SidebarComposer
{
    /**
     * @var Authentication
     */
    private Authentication $authentication;

    private Request $request;
    private ModuleInstance $moduleInstance;
    private ModuleInstanceEvaluator $evaluator;
    private ActivityInstanceResolver $activityInstanceResolver;

    /**
     * @param Request $request
     * @param Authentication $authentication
     * @param ModuleInstance $moduleInstance
     * @param ModuleInstanceEvaluator $evaluator
     * @param ActivityInstanceResolver $activityInstanceResolver
     */
    public function __construct(Request $request, Authentication $authentication, ModuleInstance $moduleInstance, ModuleInstanceEvaluator $evaluator, ActivityInstanceResolver $activityInstanceResolver)
    {
        $this->authentication = $authentication;
        $this->request = $request;
        $this->moduleInstance = $moduleInstance;
        $this->evaluator = $evaluator;
        $this->activityInstanceResolver = $activityInstanceResolver;
    }

    public function compose(View $view)
    {
        if ($this->authentication->hasUser()) {
            $isAdmin = $this->request->is(['a', 'a/*']);
            if(MarkAsManagement::$isManagement) {
                $view->with('sidebarSchema', $this->getManagementSidebar());
            } elseif ($this->moduleInstance->exists) {
                $view->with('sidebarSchema', $this->getModuleSidebar($isAdmin));
            } else {
                $view->with('sidebarSchema', $this->getBasicSidebar($isAdmin));
            }
        }
    }

    private function getModuleSidebar(bool $isAdmin = false): array
    {
        $schema = [];
        $activity = $this->moduleInstance->activity;
        $activity->moduleInstances->each(function (ModuleInstance $moduleInstance) use (&$schema, $isAdmin, $activity) {
            $evaluation = $isAdmin
                ? $this->evaluator->evaluateAdministrator($moduleInstance, $this->authentication->getUser(), $this->authentication->getGroup(), $this->authentication->getRole())
                : $this->evaluator->evaluateParticipant(
                $this->activityInstanceResolver->getActivityInstance(),
                $moduleInstance,
                $this->authentication->getUser(),
                $this->authentication->getGroup(),
                $this->authentication->getRole()
            );
            if ($evaluation->visible() && $evaluation->active()) {
                $schema[] = [
                    'title' => $moduleInstance->name,
                    'route' => sprintf('/%s/%s/%s/%s?%s', $isAdmin ? 'a' : 'p', $activity->slug, $moduleInstance->slug, $moduleInstance->alias(), url()->getAuthQueryString()),
                    'icon' => $evaluation->complete() ? 'fa fa-check' : null,
                    'highlight' => $evaluation->mandatory()
                ];
            }
        });
        return $schema;
    }

    private function getBasicSidebar(bool $isAdmin): array
    {
        $schema = [];

        $schema[] = ['title' => 'Dashboard', 'route' => route($isAdmin ? 'administrator' : 'participant')];

        if($this->canBeAdmin()) {
            $schema[] = ['title' => sprintf('Go to %s', ($isAdmin ? 'participant' : 'admin')), 'route' => sprintf('/%s', ($isAdmin ? 'p' : 'a'))];
        }

        return $schema;
    }

    private function getManagementSidebar()
    {
        return [
            ['title' => 'View Activities', 'route' => route('activity.index')],
            ['title' => 'Create Activity', 'route' => route('activity.create')],
            ['title' => 'View Logic', 'route' => route('logic.index')],
            ['title' => 'Create Logic', 'route' => route('logic.create')],
            ['title' => 'Connectors', 'route' => route('connector.index')],
            ['title' => 'Settings', 'route' => route('settings.index')],
        ];
    }

    private function canBeAdmin(): bool
    {
        /** @var Authentication $authentication */
        $authentication = app(Authentication::class);

        /** @var ActivityRepository $activityRepository */
        $activityRepository = app(ActivityRepository::class);

        $user = $authentication->getUser();
        if($activityRepository->getForAdministrator($user)->count() > 0) {
            return true;
        }

        foreach ($user->groups() as $group) {
            if($activityRepository->getForAdministrator($user, $group)->count() > 0) {
                return true;
            }
        }

        foreach ($user->roles() as $role) {
            if($activityRepository->getForAdministrator($user, $role->group(), $role)->count() > 0) {
                return true;
            }
        }

        return false;
    }
}
