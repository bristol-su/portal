<?php

namespace App\Http\View\Sidebar;

use App\Http\Middleware\MarkAsManagement;
use BristolSU\ControlDB\Models\Group;
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
            if ($evaluation->visible()) {
                $schema[] = [
                    'title' => $moduleInstance->name,
                    'route' => sprintf('/%s/%s/%s/%s?%s', $isAdmin ? 'a' : 'p', $activity->slug, $moduleInstance->slug, $moduleInstance->alias(), url()->getAuthQueryString()),
                    'complete' => $evaluation->complete(),
                    'mandatory' => $evaluation->mandatory(),
                    'active' => $evaluation->active()
                ];
            }
        });
        return $schema;
    }

    private function getBasicSidebar(bool $isAdmin): array
    {
        $schema = [];
        $user = $this->authentication->getUser();
        /** @var Group[] $groups */
        $groups = $user->groups();
        $roles = $user->roles();

        $schema[] = ['title' => 'Personal', 'route' => route(sprintf('summary.%s.user', $isAdmin ? 'a' : 'p'))];

        $groupSchema = [];
        foreach ($groups as $group) {
            $groupSchema[] = ['title' => $group->data()->name(), 'route' => route(sprintf('summary.%s.group', $isAdmin ? 'a' : 'p'), ['control_group' => $group->id()])];
        }
        $schema[] = ['title' => 'Clubs & Societies', 'children' => $groupSchema];

        $roleSchema = [];
        foreach ($roles as $role) {
            $roleSchema[] = ['title' => sprintf('%s (started %u)', $role->data()->roleName(), Carbon::make($role->created_at)->year), 'route' => route(sprintf('summary.%s.role', $isAdmin ? 'a' : 'p'), ['control_role' => $role->id()])];
        }
        $schema[] = ['title' => 'Committee Roles', 'children' => $roleSchema];
        $schema[] = ['title' => sprintf('Go to %s', ($isAdmin ? 'participant' : 'admin')), 'route' => sprintf('/%s', ($isAdmin ? 'p' : 'a'))];
        return $schema;
    }

    private function getManagementSidebar()
    {
        return [
            ['title' => 'Activities', 'children' => [
                ['title' => 'View Activities', 'route' => route('activity.index')],
                ['title' => 'Create Activity', 'route' => route('activity.create')],
            ]],
            ['title' => 'Logic', 'children' => [
                ['title' => 'View Logic', 'route' => route('logic.index')],
                ['title' => 'Create Logic', 'route' => route('logic.create')],
            ]],
            ['title' => 'Connectors', 'route' => route('connector.index')],
            ['title' => 'Settings', 'route' => route('settings.index')],
        ];
    }
}
